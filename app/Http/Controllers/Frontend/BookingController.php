<?php

namespace App\Http\Controllers\Frontend;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Place;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade as DomPDF;
use App\Jobs\SendEmailBookingReceipt;


class BookingController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /*public function booking(Request $request)
    {
        $request['user_id'] = Auth::id();

        if ($request->date) {
            $request['date'] = Carbon::parse($request->date);
        }

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',
            'numbber_of_adult' => '',
            'numbber_of_children' => '',
            'date' => '',
            'time' => '',
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'message' => '',
            'type' => ''
        ]);

        $booking = new Booking();
        $booking->fill($data);

        if ($booking->save()) {
            $place = Place::find($request['place_id']);

            if ($request->type == Booking::TYPE_CONTACT_FORM) {
                Log::debug("Booking::TYPE_CONTACT_FORM: " . $request->type);
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone_number;
                $datetime = "";
                $numberofadult = "";
                $numberofchildren = "";
                $text_message = $request->message;
            } else {
                Log::debug("Booking::submit: " . $request->type);
                $name = user()->name;
                $email = user()->email;
                $phone = user()->phone_number;
                $datetime = Carbon::parse($booking->date)->format('Y-m-d') . " " . $booking->time;
                $numberofadult = $booking->numbber_of_adult;
                $numberofchildren = $booking->numbber_of_children;
                $text_message = "";
            }

            Mail::send('frontend.mail.new_booking', [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'place' => $place->name,
                'datetime' => $datetime,
                'numberofadult' => $numberofadult,
                'numberofchildren' => $numberofchildren,
                'text_message' => $text_message,
                'booking_at' => $booking->created_at
            ], function ($message) use ($request) {
                $message->to(setting('email_system'), "{$request->first_name}")->subject('Booking from ' . $request->first_name);
            });

        }

        return $this->response->formatResponse(200, $booking, 'You successfully created your booking!');
    }*/

    public function booking(Request $request)
    {
        $request['user_id'] = Auth::id();

        if ($request->date) {
            $request['date'] = Carbon::parse($request->date);
        }

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',
            'numbber_of_adult' => '',
            'numbber_of_children' => '',
            'date' => '',
            'time' => '',
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'message' => '',
            'type' => ''
        ]);

        $codeUnique = Str::upper(Str::random(10));
       
        
        $booking = new Booking();
        $booking->tourism_info_id = $request->tourism_info_id;
        $booking->tourism_name = $request->tourism_name;
        $booking->code_unique = $codeUnique;
        $booking->status = 2;
        
        
        $booking->fill($data);

        if ($booking->save()) {
            $grandTotalSum = 0;
            $radomCharQr = Str::random(40);

            foreach ($request->input('tourism_info_category_id', []) as $key => $value) {
                if($request->qty[$key] > 0){
                    $bookingDetail = new BookingDetail();
                    $bookingDetail->booking_id = $booking->id;
                    $bookingDetail->tourism_info_category_id = $request->tourism_info_category_id[$key];
                    $bookingDetail->qty = $request->qty[$key];
                    $bookingDetail->price = $request->price[$key];
                    $bookingDetail->category_name  = $request->category_name[$key];
                    $bookingDetail->save();

                    $grandTotalSum += ($request->qty[$key] * $request->price[$key]);
                }
                
            }

            (string) QrCode::eyeColor(0, 176, 151, 46, 46, 151, 177)
                ->format('png')
                ->size(500)
                ->generate( $booking->code_unique, public_path('uploads/booking/'. $radomCharQr.'.png'));

            $booking->url_qrcode = url('/uploads/booking/' . $radomCharQr . '.png');
            $booking->grand_total = $grandTotalSum;
            $booking->save();

            
            if ($request->type == Booking::TYPE_CONTACT_FORM) {
                Log::debug("Booking::TYPE_CONTACT_FORM: " . $request->type);
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone_number;
                $datetime = "";
                //$numberofadult = "";
                //$numberofchildren = "";
                $text_message = $request->message;
            } else {
                Log::debug("Booking::submit: " . $request->type);
                $name = user()->name;
                $email = user()->email;
                $phone = user()->phone_number;
                $datetime = "";
                //$numberofadult = $booking->numbber_of_adult;
                //$numberofchildren = $booking->numbber_of_children;
                $text_message = "";
            }
          

            /*Mail::send('frontend.mail.new_booking', [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'place' => $place->name,
                //'numberofadult' => $numberofadult,
                //'numberofchildren' => $numberofchildren,
                'text_message' => $text_message,
                'booking_at' => $booking->created_at
            ], function ($message) use ($request) {
                $message->to(setting('email_system'), "{$request->first_name}")->subject('Booking from ' . $request->first_name);
            });*/
            $bookingDispatch = Booking::where('code_unique',$codeUnique)->with('detail')->first();
            $details = ['email' => $email, 'subject' => 'Booking Details', 'booking'=>$bookingDispatch ];
           // SendEmailBookingReceipt::dispatch($details);

            $emailJob = (new SendEmailBookingReceipt($details))->delay(Carbon::now()->addMinutes(1));
            dispatch($emailJob);

        }

        return $this->response->formatResponse(200, $booking, 'You successfully created your booking!');
    }

    public function downloadReceipt($codeUnique)
    {
        $receipt = Booking::myBooking()->with(['detail'])
        ->with(['user' => function ($query) {
            $query->select('id','name','email');
        }])
        ->where('code_unique',$codeUnique)
        ->firstOrFail();

        //return view('frontend.user.user_receipt',compact('receipt'));

        $pdf = DomPDF::loadView('frontend.user.user_receipt',compact('receipt'))->setPaper('A4', 'portrait');

        return $pdf->download(str::slug($receipt->tourism_name.'-'.$receipt->code_unique,'-') . '.pdf');
    }
}
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
use App\Jobs\SendEmailBookingReceiptUnpaid;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Xendit\Xendit;
use App\Traits\EncodeDecode;

class BookingController extends Controller
{
    use EncodeDecode;

    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;

        $xenditKey = env('XENDIT_IS_PRODUCTION') ? env('XENDIT_KEY_PRODUCTION') : env('XENDIT_KEY_SB');
        Xendit::setApiKey($xenditKey);
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
        $dataTourismInfoCategories = '';
        $bookingDetailsArray = [];
        $ticketData = '';
        $setQRCode = '';

       
        //try { 

            if ($request->type == Booking::TYPE_CONTACT_FORM) {
                Log::debug("Booking::TYPE_CONTACT_FORM: " . $request->type);
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone_number;
                //$datetime = "";
                //$numberofadult = "";
                //$numberofchildren = "";
                //$text_message = $request->message;
            } else {
                Log::debug("Booking::submit: " . $request->type);
                $name = user()->name;
                $email = user()->email;
                $phone = user()->phone_number;
                //$datetime = "";
                //$numberofadult = $booking->numbber_of_adult;
                //$numberofchildren = $booking->numbber_of_children;
                //$text_message = "";
            }

            $booking = new Booking();
            $booking->tourism_info_id = $request->tourism_info_id;
            $booking->tourism_name = $request->tourism_name;
            $booking->code_unique = $codeUnique;
            $booking->name = $name;
            $booking->phone_number = $phone;
            $booking->email = $email;
            $booking->date = Carbon::parse($request->date)->format('Y-m-d'); 
            $booking->status = 2;            
            $booking->fill($data);
            $setQRCode .=$booking->date->format('Y-m-d').'/'.$booking->tourism_info_id;


            if ($booking->save()) {                

                $grandTotalSum = 0;
                $radomCharQr = Str::random(40);
                try {
                    $httpClient = new Client(['base_uri' => env('BACKEND_PARIWISATA')]);
                    $response = $httpClient->request('POST', 'tourism-info/category-info',                    
                    ['form_params' => [
                        'tourism_info_category_id' =>  json_encode($request->input('tourism_info_category_id', [])),
                    ]]);
                    $codeResponse = $response->getStatusCode();
                    $dataTourismInfoCategories = json_decode($response->getBody());
                } catch (ConnectException $e) {
                    $codeResponse = $e->getCode();
                    $errorInfoResponse = 'Connection Exception | Conncetion Refused';
                    Log::notice($e->getMessage());
                    return;
                }
                
                foreach ($request->input('tourism_info_category_id', []) as $key => $value) {

                    if(($request->qty[$key] > 0) && ($request->tourism_info_id !== $dataTourismInfoCategories[$key]->tourism_info_id)){
                        $bookingDetail = new BookingDetail();
                        $bookingDetail->booking_id = $booking->id;
                        $bookingDetail->tourism_info_category_id = $dataTourismInfoCategories[$key]->id;
                        $bookingDetail->qty = $request->qty[$key];
                        $bookingDetail->price =  $dataTourismInfoCategories[$key]->price;
                        $bookingDetail->category_name  = $dataTourismInfoCategories[$key]->name;
                        $bookingDetail->save();

                        $grandTotalSum += ($request->qty[$key] * $dataTourismInfoCategories[$key]->price);

                        $ticketData .= $bookingDetail->qty.' '.$bookingDetail->category_name.',';
                        /*$bookingDetailsArray[] = [
                            'ticket_data'=>$bookingDetail->qty.' '.$bookingDetail->category_name ,
                            'price'=>$bookingDetail->price
                        ];*/

                        $setQRCode .= '/'. $bookingDetail->tourism_info_category_id.'-'.$bookingDetail->qty;

                    }
                }

                $encryptSet = $this->setQrCode($setQRCode);
                

                $codeQR = $encryptSet.'/'.$booking->date->format('Y-m-d').'/'.$codeUnique;
                //Log::debug($codeQR);
                //generate QR CODE
                (string) QrCode::eyeColor(0, 176, 151, 46, 46, 151, 177)
                    ->format('png')
                    ->size(500)
                    ->generate($codeQR, public_path('uploads/booking/'. $radomCharQr.'.png'));

                $booking->url_qrcode = url('/uploads/booking/' . $radomCharQr . '.png');
                $booking->grand_total = $grandTotalSum;
                $booking->save();

                /**BEGIN - TODO Pindahain saat pemabayaran */
               

                /*for ($i=0; $i < 5; $i++) { 
                    $encryptSet = base64_decode($encryptSet);
                    Log::debug($encryptSet);
                }*/
        
            
                //$bookingDispatch = Booking::where('code_unique',$codeUnique)->with('detail')->first();
                //$details = ['email' => $email, 'subject' => 'Booking Details', 'booking'=>$bookingDispatch ];
                // SendEmailBookingReceipt::dispatch($details);

                //$emailJob = (new SendEmailBookingReceipt($details))->delay(Carbon::now()->addMinutes(1));
                //dispatch($emailJob);
                //Install supervisior di live server
                /**END - TODO Pindahain saat pemabayaran */


                $bookingToEmail = Booking::where('code_unique',$codeUnique)->with(['detail'])->first();

                $details = ['email' => $booking->email, 'subject' => "Ulinyu.id - $booking->tourism_name", 'booking'=>$bookingToEmail ];
                // SendEmailBookingReceipt::dispatch($details);
                //$emailJob = (new SendEmailBookingReceiptUnpaid($details))->delay(Carbon::now()->addMinutes(1));
                //dispatch($emailJob);

                $data = [
                    'name'=>$name,
                    'tourism_name'=>$booking->tourism_name,
                    'ticket_data'=> rtrim($ticketData, ","),
                    'grand_total'=> number_format($booking->grand_total),
                    'code_unique'=> $codeUnique,
                    /*'booking'=>
                    [
                        'name' =>  $booking->tourism_name,
                        'grand_total' =>  $booking->grand_total ,
                    ],
                    'booking_detail'=> $bookingDetailsArray*/
                ];

            

            return $this->response->formatResponse(200, $data, 'Ticket Tersedia silahkan klik "Selanjutnya"');
       /* } catch (Exception $e) {
            report($e);
            return $this->response->formatResponse(500, $booking, 'An error occurred. Please try again.');
        }*/
        }
    }

    public function bookingPayment(request $request)
    {

        $booking = Booking::where('code_unique', $request->code_unique)->where('status',2)->first();

        $params = ['external_id' =>  $booking->id.'-'.Carbon::now()->translatedFormat('dmYHis').'-ULINYU',
          'payer_email' => $booking->email,
          'description' => 'Pembayaran Booking Ulinyu '.$booking->email.' '.$booking->code_unique.' '.number_format($booking->grand_total),
          'amount' => $booking->grand_total
        ];

        $createInvoice = \Xendit\Invoice::create($params);  
        $url = $createInvoice['invoice_url'];
        
        return redirect()->away($url);

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
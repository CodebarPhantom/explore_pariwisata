<?php

namespace App\Http\Controllers\API\Booking;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingPayment;
use App\Models\BookingPaymentXendit;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Jobs\SendEmailBookingReceipt;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Xendit\Xendit;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class BookingController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;

        $xenditKey = env('XENDIT_IS_PRODUCTION') ? env('XENDIT_KEY_PRODUCTION') : env('XENDIT_KEY_SB');
        Xendit::setApiKey($xenditKey);
    }

    public function getByCodeUnique(Request $request)
    {
        $myBooking = Booking::with(['detail'])->where('code_unique', $request->code_unique)->where('status',1)->where('visit_time',NULL)->first();

        if($myBooking !== NULL){
            $response = 
            [
                'id'=>$myBooking->id,
                'tourism_info_id'=>$myBooking->tourism_info_id,
                "tourism_name"=>$myBooking->tourism_name,
                "code_unique"=>$myBooking->code_unique,
                "grand_total"=>$myBooking->grand_total,
                "status"=>$myBooking->status,
                "status_name"=>$myBooking->status_name,
                "status_bs_color"=>$myBooking->status_bs_color,
                "details"=>$myBooking->detail
            ];
            $myBooking->visit_time = Carbon::now()->format('Y-m-d H:i:s');
            $myBooking->save();
            
            
            return $this->response->formatResponse(200,  $response, "success");
        }else{
            return response()->json(
                [
                    'code' => 422,
                    'data' => "Ticket sudah terpakai / Belum melakukan Pembayaran",
                    'message' => "Ticket sudah terpakai / Belum melakukan Pembayaran",
                ],
                422
            );

            //return $this->response->formatResponse(422,  "Ticket sudah terpakai / Belum melakukan Pembayaran", "Ticket sudah terpakai / Belum melakukan Pembayaran");
        }
        

    }

    public function visitTimeByCodeUnique(Request $request){
        $myBooking = Booking::where('code_unique', $request->code_unique)->first();
        $myBooking->visit_time = Carbon::now()->format('Y-m-d H:i:s');
        $myBooking->save();
        
        return $this->response->formatResponse(200,  "Waktu Kunjungan sudah tercatat", "Waktu Kunjungan $request->code_unique sudah tercatat");

    }

    public function bookingHandlerXendit(request $request)
    {
        $xenditFromBnet = json_decode($request->xendit_from_bnet,true);
      

        $transaction = $xenditFromBnet['status'];
        $type = $xenditFromBnet['payment_method'];
        $order_id = $xenditFromBnet['external_id'];
        $invoiceId = explode('-', $xenditFromBnet['external_id']);
        $grossAmount = $xenditFromBnet['paid_amount'];

        if ($transaction == 'PAID') {
            
            
            $booking = Booking::where('id', $invoiceId[0])->with(['detail'])->first();
            $booking->payment = $grossAmount;
            $booking->status = 1;
            $booking->save();       
               
                    

            $bookingPaymentXendit = new BookingPaymentXendit();
            $bookingPaymentXendit->xendit_id = $xenditFromBnet['id'];
            $bookingPaymentXendit->external_id = $order_id;
            $bookingPaymentXendit->payment_method = $type;
            $bookingPaymentXendit->status = $transaction;
            $bookingPaymentXendit->paid_amount = $xenditFromBnet['paid_amount'];

            if ($type == 'CREDIT_CARD') {
                $bookingPaymentXendit->fees_paid_amount = $xenditFromBnet['paid_amount'] * 0.0519 + 2000; // biaya xendit credit card2.90% + + 2.29% PPN + Rp 2.000
                $bookingPaymentXendit->adjusted_received_amount = $xenditFromBnet['paid_amount'] - $bookingPaymentXendit->fees_paid_amount;
            } elseif($type == 'EWALLET') {
                $bookingPaymentXendit->fees_paid_amount = $xenditFromBnet['paid_amount'] * 0.0165; // biaya xendit ewallet 1.65% 
                $bookingPaymentXendit->adjusted_received_amount = $xenditFromBnet['paid_amount'] - $bookingPaymentXendit->fees_paid_amount;
            }else{
                $bookingPaymentXendit->adjusted_received_amount = $xenditFromBnet['adjusted_received_amount'];
                $bookingPaymentXendit->fees_paid_amount = $xenditFromBnet['fees_paid_amount'];
            }

            $bookingPaymentXendit->description = $xenditFromBnet['description'];
            $bookingPaymentXendit->save();

            $bookingPayment = new BookingPayment();
            $bookingPayment->payment_gateway_id = $order_id;
            $bookingPayment->booking_id = $booking->id;
            $bookingPayment->pay_date = carbon::now()->format('Y-m-d h:i:s');
            $bookingPayment->amount = $grossAmount; 
            $bookingPayment->status = $transaction;
            $bookingPayment->type ="XENDIT";
            $bookingPayment->note = $xenditFromBnet['description'];
            $bookingPayment->save();

            //$bookingDispatch = Booking::where('code_unique',$codeUnique)->with('detail')->first();
            $details = ['email' => $booking->email, 'subject' => "Ulinyu.id - $booking->tourism_name", 'booking'=>$booking ];
            // SendEmailBookingReceipt::dispatch($details);
            $emailJob = (new SendEmailBookingReceipt($details))->delay(Carbon::now()->addMinutes(1));
            dispatch($emailJob);


        }
        //return $this->response->formatResponse(200, 'ya', 'Success');
        
    }

    public function booking(Request $request)
    {
        //$request['user_id'] = Auth::id();
        
        //return user()->name;

        //if ($request->date) {
        //    $request['date'] = Carbon::parse($request->date);
        //}

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',            
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
       
        //try { 

            if ($request->type_form == Booking::TYPE_CONTACT_FORM) {
                Log::debug("Booking::TYPE_CONTACT_FORM: " . $request->type);
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone_number;
                //$datetime = "";
                //$numberofadult = "";
                //$numberofchildren = "";
                //$text_message = $request->message;
            } else {
                Log::debug("Booking::submit: " . $request->type_form);
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
            $booking->status = 2;            
            $booking->fill($data);

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

                        $ticketData .= $bookingDetail->qty.' '.$bookingDetail->category_name.', ';
                        /*$bookingDetailsArray[] = [
                            'ticket_data'=>$bookingDetail->qty.' '.$bookingDetail->category_name ,
                            'price'=>$bookingDetail->price
                        ];*/

                    }
                }

                //generate QR CODE
                (string) QrCode::eyeColor(0, 176, 151, 46, 46, 151, 177)
                    ->format('png')
                    ->size(500)
                    ->generate( $booking->code_unique, public_path('uploads/booking/'. $radomCharQr.'.png'));

                $booking->url_qrcode = url('/uploads/booking/' . $radomCharQr . '.png');
                $booking->grand_total = $grandTotalSum;
                $booking->save();

                /**BEGIN - TODO Pindahain saat pemabayaran */
                
            
                //$bookingDispatch = Booking::where('code_unique',$codeUnique)->with('detail')->first();
                //$details = ['email' => $email, 'subject' => 'Booking Details', 'booking'=>$bookingDispatch ];
                // SendEmailBookingReceipt::dispatch($details);

                //$emailJob = (new SendEmailBookingReceipt($details))->delay(Carbon::now()->addMinutes(1));
                //dispatch($emailJob);
                //Install supervisior di live server
                /**END - TODO Pindahain saat pemabayaran */


                $data = [
                    'name'=>$name,
                    'tourism_name'=>$booking->tourism_name,
                    'ticket_data'=> rtrim($ticketData, ", "),
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

        return $this->response->formatResponse(200, $url, 'OK');


    }
    

    
}
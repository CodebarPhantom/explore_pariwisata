<?php

namespace App\Http\Controllers\API;


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


class BookingController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
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
            
            return $this->response->formatResponse(200,  $response, "success");
        }else{
            return $this->response->formatResponse(422,  "Ticket sudah terpakai / Belum melakukan Pembayaran", "Ticket sudah terpakai / Belum melakukan Pembayaran");
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
    

    
}
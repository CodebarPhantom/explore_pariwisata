<?php

namespace App\Http\Controllers\API;


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

class BookingController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getByCodeUnique(Request $request)
    {
        
               

        $myBooking = Booking::with(['detail'])->where('code_unique', $request->code_unique)->first();

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

    }

    
}
<?php

namespace App\Http\Controllers\API\Home;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index()
    {
        $codeResponse ="";
        $dataTourismInfos = "";
        $errorInfoResponse = "";

        try {
            $httpClient = new Client(['base_uri' => env('BACKEND_PARIWISATA')]);
            $response = $httpClient->request('GET', 'tourism-info');
            $codeResponse = $response->getStatusCode();
            $dataTourismInfos = json_decode($response->getBody());
        } catch (ConnectException $e) {
            $codeResponse = $e->getCode();
            $errorInfoResponse = 'Connection Exception | Conncetion Refused';
            Log::notice($e->getMessage());

            return response()->json([
                    'code' => $codeResponse,
                    'data' => "Invalid Data Response",
                    'message' =>  $errorInfoResponse,
                ]);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                    'code' => 500,
                    'data' => "Invalid Data Response",
                    'message' =>  "Internal Server Error",
                ],500);
            //return abort(500);
        }
        return response()->json([
            'code' => 200,
            'data' => $dataTourismInfos,
            'message' =>  "OK",
        ],200);
        //return view("frontend.home.home_{$template}", compact('codeResponse','dataTourismInfos','errorInfoResponse'));
        
        
    }


}

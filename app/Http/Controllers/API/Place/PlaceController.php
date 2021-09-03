<?php

namespace App\Http\Controllers\API\Place;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{
    

    public function detail($slug)
    {
        try {
            $httpClient = new Client(['base_uri' => env('BACKEND_PARIWISATA')]);
            $response = $httpClient->request('GET', "tourism-info/$slug");
            $codeResponse = $response->getStatusCode();
            $showTourism = json_decode($response->getBody());
        } catch (ConnectException $e) {
            $codeResponse = $e->getCode();
            $errorInfoResponse = 'Connection Exception | Conncetion Refused';
            Log::notice($e->getMessage());

            return response()->json([
                'code' => $codeResponse,
                'data' => "Invalid Data Reaponse",
                'message' =>  $errorInfoResponse,
            ]);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                'code' => 500,
                'data' => "Invalid Data Response",
                'message' =>  "Internal Server Error",
            ],500);
        }

        return response()->json([
            'code' => 200,
            'data' => $showTourism,
            'message' =>  "OK",
        ],200);
    }

   
}

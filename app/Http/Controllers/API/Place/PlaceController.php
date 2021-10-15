<?php

namespace App\Http\Controllers\API\Place;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Review;
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

            $reviews = Review::select('id','name',DB::raw('round(AVG(quantity),0) as quantity'))->where('tourism_info_id',$showTourism->id)
            ->groupBy('id','name')
            ->get();//->avg('rating');

            return $reviews;

            //array_push($showTourism, 'yayaya');
            $showTourism->rating = $reviews;
            json_encode($showTourism);

            //return json_encode($showTourism);

            /*$libraries = $reviews->map(function($library) {

                // All the books of the library
                $test = $library;
            
                // set book count and average rating to the library object
                $test->book_count = $test->count();
                $test->average_rating = $test->average('rating');
            
                return $library;
            });*/

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

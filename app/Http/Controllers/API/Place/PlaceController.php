<?php

namespace App\Http\Controllers\API\Place;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Review;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use DB;

class PlaceController extends Controller
{
    

    public function detail($slug)
    {
        try {
            $httpClient = new Client(['base_uri' => env('BACKEND_PARIWISATA')]);
            $response = $httpClient->request('GET', "tourism-info/$slug");
            $codeResponse = $response->getStatusCode();
            $showTourism = json_decode($response->getBody());

            $reviews = Review::select(DB::raw('CAST(IFNULL(AVG(rating),0) AS DECIMAL(2,1)) as avg_rating'))
            ->addSelect([
                'count_rating_1' => Review::selectRaw('count(rating)')->where('rating',1)->where('tourism_info_id',$showTourism->id),
                'count_rating_2' => Review::selectRaw('count(rating)')->where('rating',2)->where('tourism_info_id',$showTourism->id),
                'count_rating_3' => Review::selectRaw('count(rating)')->where('rating',3)->where('tourism_info_id',$showTourism->id),
                'count_rating_4' => Review::selectRaw('count(rating)')->where('rating',4)->where('tourism_info_id',$showTourism->id),
                'count_rating_5' => Review::selectRaw('count(rating)')->where('rating',5)->where('tourism_info_id',$showTourism->id),
            ])
            ->where('tourism_info_id',$showTourism->id)
            ->first();//->avg('rating');

            //return $reviews;

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

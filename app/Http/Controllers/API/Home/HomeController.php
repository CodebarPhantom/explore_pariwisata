<?php

namespace App\Http\Controllers\API\Home;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Review;

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
            $response = $httpClient->request('GET', 'tourism-info', [
                "query" => [
                    "tourism_category" => request('tourism_category'),
                    "tourism_name" => request('tourism_name'),

                ],
            ]);
            $codeResponse = $response->getStatusCode();
            $dataTourismInfos = json_decode($response->getBody());

            foreach ($dataTourismInfos as $dataTourismInfo) {
                $avgRating = Review::select(DB::raw('CAST(IFNULL(AVG(rating),0) AS DECIMAL(2,1)) as avg_rating'))->where('tourism_info_id',$dataTourismInfo->id)->first();
                $dataTourismInfo->avg_rating =  $avgRating->avg_rating;
            }

            json_encode($dataTourismInfos);
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
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: minhthe
 * Date: 2020-04-27
 * Time: 16:07
 */

namespace App\Http\Controllers\API\User;

use App\Commons\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class UserController extends Controller
{

    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /*public function getUserInfo(Request $request)
    {
        $user = $this->getUserByApiToken($request);
        return $user;
    }

    public function getPlaceByUser($user_id)
    {
        $places = Place::query()
            ->where('user_id', $user_id)
            ->paginate();

        return $places;
    }

    public function getPlaceWishlistByUser($user_id)
    {
        $wishlists = Wishlist::query()
            ->where('user_id', $user_id)
            ->get('place_id')->toArray();

        $wishlists = array_column($wishlists, 'place_id');

        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->whereIn('id', $wishlists)
            ->paginate();

        return $places;
    }*/

    public function myBooking(Request $request)
    {
        $keyword = $request->keyword;

        $filter = [
            'keyword' => $keyword
        ];


        

        //dd($filter['keyword']);

        $myBookings = Booking::myBooking()->with(['detail'])
        /*->when($filter['tourism'], function ($query, $filter) {
            $query->where('tourism_id', '=', $filter['tourism']);
        })*/
        ->when($keyword, function ($query,$keyword) {
            $query->where('tourism_name', 'like', '%' . $keyword . '%');
        })
        ->orderBy('created_at','desc')->paginate(10);

        return $this->response->formatResponse(200, $myBookings, 'OK');


        //$app_name = setting('app_name', 'Ulinyu.id');
        //SEOMeta("My Bookings - {$app_name}");
        //return view('frontend.user.user_my_booking', compact('myBookings','filter'));


    }

}

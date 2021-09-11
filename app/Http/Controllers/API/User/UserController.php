<?php
/**
 * Created by PhpStorm.
 * User: minhthe
 * Date: 2020-04-27
 * Time: 16:07
 */

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\ApiController;
use App\Commons\Response;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Traits\UrlImage;
use Illuminate\Validation\ValidationException;
use DB, Exception;
use App\Traits\CommonResponse;
use Illuminate\Support\Facades\Hash;




class UserController extends ApiController
{

    use UrlImage, CommonResponse;

    /*private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }*/

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

    public function myBookingUsed(Request $request)
    {
        $keyword = $request->keyword;
        /*$status = $request->status;
        $filter = [
            'keyword' => $keyword
        ];*/
        $myBookings = Booking::myBooking()->used()->with(['detail'])
        /*->when($filter['tourism'], function ($query, $filter) {
            $query->where('tourism_id', '=', $filter['tourism']);
        })*/
        ->when($keyword, function ($query,$keyword) {
            $query->where('tourism_name', 'like', '%' . $keyword . '%');
        })
        ->orderBy('created_at','desc')->paginate(10);

        return $this->formatResponse(200, $myBookings, 'Success');


        //$app_name = setting('app_name', 'Ulinyu.id');
        //SEOMeta("My Bookings - {$app_name}");
        //return view('frontend.user.user_my_booking', compact('myBookings','filter'));


    }

    public function myBookingPending(Request $request)
    {
        $keyword = $request->keyword;
        /*$status = $request->status;
        $filter = [
            'keyword' => $keyword
        ];*/
        $myBookings = Booking::myBooking()->pending()->with(['detail'])
        /*->when($filter['tourism'], function ($query, $filter) {
            $query->where('tourism_id', '=', $filter['tourism']);
        })*/
        ->when($keyword, function ($query,$keyword) {
            $query->where('tourism_name', 'like', '%' . $keyword . '%');
        })
        ->orderBy('created_at','desc')->paginate(10);

        return $this->formatResponse(200, $myBookings, 'Success');


        //$app_name = setting('app_name', 'Ulinyu.id');
        //SEOMeta("My Bookings - {$app_name}");
        //return view('frontend.user.user_my_booking', compact('myBookings','filter'));


    }

    
    public function myBookingPaid(Request $request)
    {
        $keyword = $request->keyword;
        /*$status = $request->status;
        $filter = [
            'keyword' => $keyword
        ];*/
        $myBookings = Booking::myBooking()->paid()->with(['detail'])
        /*->when($filter['tourism'], function ($query, $filter) {
            $query->where('tourism_id', '=', $filter['tourism']);
        })*/
        ->when($keyword, function ($query,$keyword) {
            $query->where('tourism_name', 'like', '%' . $keyword . '%');
        })
        ->orderBy('created_at','desc')->paginate(10);

        return $this->formatResponse(200, $myBookings, 'Success');


        //$app_name = setting('app_name', 'Ulinyu.id');
        //SEOMeta("My Bookings - {$app_name}");
        //return view('frontend.user.user_my_booking', compact('myBookings','filter'));


    }

    public function getProfile()
    {
        $profile = User::select('id','name','email','avatar','phone_number','facebook','instagram','is_admin','status')->find(auth()->user()->id);
        return $this->formatResponse(200, $profile, 'Success');
    }

    public function updateProfile(Request $request)
    {
        $data = $this->validate($request, [
            'full_name' => 'required',
            'phone_number' => '',
            'facebook' => '',
            'instagram' => '',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ]);
        $user = User::find(auth()->user()->id);
        
        DB::beginTransaction();
        try {
            $user->name = $request->full_name;
            $user->phone_number = $request->phone;
            $user->facebook = $request->facebook;
            $user->instagram =  $request->instagram;
            if ($request->avatar) $user->avatar = $this->updateImage($request,'avatar','public/profile/',$user->avatar);     
            $user->save();     

            DB::commit();

            $message = 'Profile updated successfully';
            return $this->setResponse(compact('message'));
        }catch (ValidationException $e) {
            DB::rollBack();

            $this->status = $e->getMessage();
            $this->code = $e->status;

            $message = $e->errors();
            return $this->setResponse(compact('message'));
        }catch (Exception $e) {

            DB::rollBack();
            report($e);

            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
              

    }

    public function updatePassword(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $data = $this->validate($request, [
            'old_password' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required'],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            $this->status = 'error';
            $this->code = 422;
            $message = 'Wrong old password!';
            return $this->setResponse(compact('message'));
        }

        if ($request->password !== $request->password_confirmation) {
            $this->status = 'error';
            $this->code = 422;
            $message = 'Password confirm do not match!';
            return $this->setResponse(compact('message'));
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $message = 'Change password success!';
        return $this->setResponse(compact('message'));
    }

}

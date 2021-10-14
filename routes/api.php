<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Home\HomeController;
use App\Http\Controllers\API\Place\PlaceController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Wishlist\WishlistController;
use App\Http\Controllers\API\Review\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$router->group([
    'as' => 'api_',
    'middleware' => []], function () use ($router) {

    $router->post('/upload-image', 'ImageController@upload')->name('upload_image');

    $router->get('/cities', 'Frontend\CityController@search')->name('city_search');
    $router->put('/city/status', 'Admin\CityController@updateStatus')->name('city_update_status');
    $router->get('/cities/{country_id}', 'Admin\CityController@getListByCountry')->name('city_get_list');

    $router->get('/categories', 'Frontend\CategoryController@search')->name('category_search');
    $router->put('/category/status', 'Admin\CategoryController@updateStatus')->name('category_update_status');
    $router->put('/category/is-feature', 'Admin\CategoryController@updateIsFeature')->name('category_update_is_feature');

    $router->put('/places/status', 'Admin\PlaceController@updateStatus')->name('place_update_status');
    //$router->get('/places/map', 'Frontend\PlaceController@getListMap')->name('place_get_list_map');

    $router->put('/reviews/status', 'Admin\ReviewController@updateStatus')->name('review_update_status');

    //$router->get('/search', 'Frontend\HomeController@ajaxSearch')->name('search');

    $router->put('/posts/status', 'Admin\PostController@updateStatus')->name('post_update_status');

    $router->put('/users/status', 'Admin\UserController@updateStatus')->name('user_update_status');
    $router->put('/users/role', 'Admin\UserController@updateRole')->name('user_update_role');

    $router->put('/languages/default', 'Admin\LanguageController@setDefault')->name('language_set_default');

    $router->post('/user/reset-password', 'Frontend\ResetPasswordController@sendMail')->name('user_forgot_password');
});


$router->group([
    'prefix' => 'app',
    'namespace' => 'API',
    'as' => 'api_app_',
    'middleware' => []], function () use ($router) {

    

    $router->get('/cities', 'CityController@list');
    $router->get('/cities/{id}', 'CityController@detail')->where('id', '[0-9]+');
    $router->get('/cities/popular', 'CityController@popularCity');

    $router->get('/posts/inspiration', 'PostController@postInspiration');

    $router->get('/places/{id}', 'PlaceController@detail')->where('id', '[0-9]+');

    $router->get('/places/search', 'PlaceController@search');

    /**
     * Users
     */
    $router->get('/users', 'UserController@getUserInfo')->middleware('auth:api');
    $router->get('/users/{user_id}/place', 'UserController@getPlaceByUser')->middleware('auth:api');
    $router->get('/users/{user_id}/place/wishlist', 'UserController@getPlaceByUser');
    $router->get('/users/{user_id}/place/wishlist', 'UserController@getPlaceByUser');
    //$router->post('/users/login', 'UserController@login');

    /**
     * Places
     */
    $router->post('/places/wishlist', 'PlaceController@addPlaceToWishlist')->middleware('auth:api');
    $router->delete('/places/wishlist', 'PlaceController@removePlaceFromWishlist')->middleware('auth:api');


    /**
     * Bookings
     */
    Route::namespace('Booking')->group(function () {
        Route::post('/booking/code-unique', 'BookingController@getByCodeUnique');
        Route::post('/booking/check-code-unique', 'BookingController@checkCodeUnique');
        Route::post('/booking/visit-time', 'BookingController@visitTimeByCodeUnique');
        Route::post('/booking/handler-xendit', 'BookingController@bookingHandlerXendit');
        Route::post('/booking/bookings', 'BookingController@booking')->middleware('auth:sanctum'); // awas ini booking ga harus login kan
        Route::post('/booking/payment','BookingController@bookingPayment')->middleware('auth:sanctum');
        Route::post('/booking/direct-bookings', 'BookingController@booking'); // awas ini booking ga harus login kan
        Route::post('/booking/direct-payment','BookingController@bookingPayment');




    });


    /**
     * Auth
     */    
    Route::namespace('Auth')->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', [LoginController::class, 'index']);
            Route::post('/register', [RegisterController::class, 'register']);
            Route::post('/reset-password', [ResetPasswordController::class, 'sendMail']);


            Route::middleware('auth:sanctum', 'api.user')->group(function () {
                Route::post('/logout', [LogoutController::class, 'index']);
            });
        });
    });

    Route::namespace('Home')->group(function () {
        Route::group(['prefix' => 'home'], function () {
            Route::get('/index', [HomeController::class, 'index']);

           /* Route::middleware('auth:sanctum', 'api.user')->group(function () {
                Route::get('/data', [LoginController::class, 'show']);
                Route::post('/logout', [LogoutController::class, 'index']);
            });*/
        });
    });

    Route::namespace('Place')->group(function () {
        Route::group(['prefix' => 'place'], function () {
            Route::get('/{slug}', [PlaceController::class, 'detail']);
           /* Route::middleware('auth:sanctum', 'api.user')->group(function () {
                Route::get('/data', [LoginController::class, 'show']);
                Route::post('/logout', [LogoutController::class, 'index']);
            });*/
        });
    });

    Route::namespace('Review')->group(function () {

        Route::group(['prefix' => 'review'], function () {
            Route::get('/tourism-show',[ReviewController::class,'showTourismReview']);
            Route::post('/tourism-store',[ReviewController::class,'storeTourismReview'])->middleware('auth:sanctum', 'api.user');

        });

    });


    Route::namespace('User')->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/my-booking-pending', [UserController::class, 'myBookingPending'])->middleware('auth:sanctum', 'api.user');
            Route::get('/my-booking-paid', [UserController::class, 'myBookingPaid'])->middleware('auth:sanctum', 'api.user');
            Route::get('/my-booking-used', [UserController::class, 'myBookingUsed'])->middleware('auth:sanctum', 'api.user');
            
            
            
            Route::get('/my-profile', [UserController::class, 'getProfile'])->middleware('auth:sanctum', 'api.user');
            Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum', 'api.user');
            Route::post('/update-password', [UserController::class, 'updatePassword'])->middleware('auth:sanctum', 'api.user');
            Route::post('/reschedule-booking', [UserController::class, 'rescheduleBooking'])->middleware('auth:sanctum', 'api.user');


        });
    });

    Route::namespace('Wishlist')->group(function () {
        Route::middleware('auth:sanctum', 'api.user')->prefix('wishlist')->group(function () {
            Route::get('/show', [WishlistController::class, 'show']);
            Route::post('/store', [WishlistController::class, 'store']);


        });

    });



});

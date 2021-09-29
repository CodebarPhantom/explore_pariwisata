<?php

namespace App\Http\Controllers\API\Wishlist;

use App\Http\Controllers\ApiController;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use DB, Exception;


class WishlistController extends ApiController
{

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

                if($request->wishlist === 'save'){   
                    $checkWishlist = Wishlist::myWishlist()->where('tourism_info_id',$request->tourism_info_id)->first();
                    if($checkWishlist == NULL){
                        $wishlist = new Wishlist();
                        $wishlist->tourism_info_id = $request->tourism_info_id;
                        $wishlist->slug = $request->slug;
                        $wishlist->name = $request->name;
                        $wishlist->url_cover_image = $request->url_cover_image;

                        $wishlist->user_id = auth()->user()->id;
                        $wishlist->save();
                        $message = "Pariwisata telah ditambahkan ke favorit";
                    }else{
                        $message = "Pariwisata ini sudah masuk pada favorit";
                    }

                }else{
                    $wishlist = Wishlist::myWishlist()->where('tourism_info_id',$request->tourism_info_id)->delete();
                    $message = "Pariwisata telah dihapus dari favorit";

                }
                DB::commit();

           

            
        }catch (Exception $e) {

            DB::rollBack();
            report($e);

            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }

        return $this->setResponse(compact('message'));

    }

    public function show()
    {
        $checkWishlist = Wishlist::myWishlist()->get();

        return $this->setResponse(compact('checkWishlist'));


    }
}
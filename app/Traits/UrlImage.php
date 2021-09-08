<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Storage;


trait UrlImage
{
    public function storeImage($request, $requestField, $pathImage){
        $photoPath = $request->file($requestField)->store($pathImage);
        $photoUrl = url('/storage') . str_replace('public','', $photoPath);        
        return $photoUrl;
    }

    public function updateImage(Request $request, $requestField, $pathImage, $urlExisting){
        Storage::delete(str_replace(url('storage'), 'public', $urlExisting));
        $photoPath = $request->file($requestField)->store($pathImage);
        $photoUrl = url('/storage') . str_replace('public', '', $photoPath);
        return $photoUrl;
    }
}
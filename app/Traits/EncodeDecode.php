<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait EncodeDecode
{
    public function setQrCode($set)
    {
        for ($i=0; $i < 5; $i++) { 
            $set = base64_encode($set);
            //Log::debug($set);
        }

        return $set;
    }
}
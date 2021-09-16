<?php

namespace App\Traits;

trait EncodeDecode
{
    public function setQrCode($set)
    {
        for ($i=0; $i < 5; $i++) { 
            $setQRCode = base64_encode($set);
        }

        return $setQRCode;
    }
}
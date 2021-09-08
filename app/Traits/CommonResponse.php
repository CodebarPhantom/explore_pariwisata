<?php

namespace App\Traits;

use App\Commons\Message;

trait CommonResponse
{
    public function formatResponse($code, $data, $message = '')
    {
        $messageObj = new Message();
        return response()->json([
            "code" => $code,
            "message" => (!$message) ? $messageObj->getMessage($code) : (Message::genErrorMessage($message)),
            "data" => $data
        ]);
    }
}
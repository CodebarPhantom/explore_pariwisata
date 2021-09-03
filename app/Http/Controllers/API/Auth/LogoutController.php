<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        // Revoke all tokens...
        // return $request
        //     ->user()
        //     ->tokens()
        //     ->delete();

        // Revoke the user's current token...
        return response(
            [
                'status' => $request
                    ->user()
                    ->currentAccessToken()
                    ->delete(),
            ],
            200
        );
    }
}

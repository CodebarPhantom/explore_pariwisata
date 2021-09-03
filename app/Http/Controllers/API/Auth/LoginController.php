<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->status == '1'){
                $token = $request->user()->createToken($request->token_name);

                return ['name'=>auth()->user()->name,'email'=>auth()->user()->email,'token' => $token->plainTextToken];
            } else {
                return response(['token' => null], 403);
            }
        } else {
            return response(['token' => null], 403);
        }
    }

}

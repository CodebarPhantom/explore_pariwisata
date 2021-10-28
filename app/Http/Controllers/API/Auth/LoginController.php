<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Laravel\Socialite\Facades\Socialite;

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

    public function handleProviderCallback($provider, Request $request)
    {
        

        if ($provider == "facebook" && $request->error) {
            return response(["status" => "error", "message" => $request->error_description], 500);
        }

        $socialite = Socialite::driver($provider);

        $user = $socialite->userFromToken(request("token"));

        if (!$user->getEmail()) {
            return response(["status" => "error", "message" => "Please provide your email address."], 500);
        }

        $member = User::whereEmail($user->getEmail())->first();

        if (!$member) {
            $member = new User();            
            $member->name = $user->getName();
            $member->email = $user->getEmail();
            $member->save();
        }
        
        
        

        $token = $member->createToken($provider);

        $result = [
            'name'=>auth()->user()->name,
            'email'=>auth()->user()->email,
            'token' => $token->plainTextToken
        ];

        return response(compact("result"));
    }

}

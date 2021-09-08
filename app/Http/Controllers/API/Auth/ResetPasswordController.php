<?php

namespace App\Http\Controllers\API\Auth;

use App\Commons\Message;
use App\Commons\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->response->formatResponse(404, [], 'Email not found!');
        }

        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);

        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }

        return $this->response->formatResponse(200, [], 'Password reset email telah dikirimkan ke email kamu.');
    }

    public function reset(Request $request)
    {
        $token = $request->token;
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return back()->with('error', 'This password reset token is invalid.');
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            return back()->with('error', 'This password reset token is invalid.');
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return back()->with('error', 'We can\'t find a user with that e-mail address.');
        }

        $rules = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        $message_errors = [
            'required' => ':attribute wajib di isi,',
            'confirmed'=>':attribute harus sama dengan confirm :attribute,',
            'min'=>':attribute minimal 8 karakter'];
        $validator = Validator::make($request->all(), $rules, $message_errors);

        if ($validator->fails()) {
            $respValidator = $validator->messages();

            return back()->with('error', Message::genErrorMessage($respValidator)) ;
           
        } else {
            $updatePasswordUser = $user->update(['password' => bcrypt($request->password)]);
            $passwordReset->delete();
            return back()->with('success', 'Your password has been reset successfully. You can login with your new password now!');
        }

        

    }
    
}

<?php

namespace App\Http\Controllers\Auth;

use App\Commons\APICode;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $user;
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Response $response)
    {
        $this->middleware('guest')->except('logout');
        $this->user = $user;
        $this->response = $response;
    }

    public function login(Request $request)
    {
        $validator = $this->user->validateLogin($request);
        $user_data = [];

        if ($validator->code == APICode::SUCCESS) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $validator->code = APICode::PAGE_NOT_FOUND;
                $validator->message = 'Email not found!';
            } else {
                if ($user->status === 0) {
                    $validator->code = APICode::PERMISSION_DENIED;
                    $validator->message = 'Account is deactive!';
                } elseif (!Hash::check($request->password, $user->password)) {
                    $validator->code = APICode::PAGE_NOT_FOUND;
                    $validator->message = 'Wrong password!';
                } else {
                    Auth::attempt(['email' => $request->email, 'password' => $request->password], true);
                    $user_data = $this->guard()->user();

                    if (Schema::hasColumn('users', 'api_token')) {
                        $user->generateApiToken();
                    }
                }
            }
        }

        return $this->response->formatResponse($validator->code, $user_data, $validator->message);
    }

    /**
     * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider($provider)
    {
        //dd(config('services.google'));
        //dd(config('services.facebook'));

        //dd( env('GOOGLE_CLIENT_ID'));
        return Socialite::driver($provider)
        ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            dd('error');
            return redirect('/login');
        }
        // only allow people with @company.com to login
       /* if(explode("@", $user->email)[1] !== 'company.com'){
            return redirect()->to('/');
        }*/
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in

            Auth::login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            //$newUser->google_id       = $user->id;
            //$newUser->avatar          = $user->avatar;
            //$newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            Auth::login($newUser, true);
        }
        return redirect()->route('home');
    }
}

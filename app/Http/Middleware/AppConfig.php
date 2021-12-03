<?php

namespace App\Http\Middleware;

use Closure;

class AppConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /**
         * Config Social Auth
         */
      /*  $config_facebook = [
            'client_id' => setting('facebook_app_id'),
            'client_secret' => setting('facebook_app_secret'),
            'redirect' => route('login_social_callback', 'facebook'),
        ];
        $config_google = [
            'client_id' => setting('google_app_id'),
            'client_secret' => setting('google_app_secret'),
            'redirect' => route('login_social_callback', 'google'),
        ];
        config(['services.facebook' => $config_facebook]);
        config(['services.google' => $config_google]);*/

        /**
         * Config SMTP
         */
        //awas ini smtp bisa nge overide gan
        config(['mail.driver' => setting('mail_driver', 'smtp')]);
        config(['mail.host' => 'smtp.bnet.id']);
        config(['mail.port' => '465']);
        config(['mail.username' => env('MAIL_USERNAME')]);
        config(['mail.password' => env('MAIL_PASSWORD')]);
        config(['mail.encryption' =>  'ssl']);
        config(['mail.from.address' => 'support@ulinyu.id']);
        config(['mail.from.name' => 'System Ulinyu']);


        return $next($request);
    }
}

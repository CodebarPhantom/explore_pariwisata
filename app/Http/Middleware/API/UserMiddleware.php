<?php

namespace App\Http\Middleware\API;

use Closure;
use App\Http\Controllers\API\Auth\LogoutController;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->status) {
            return $next($request);
        } else {
            $request
                ->user()
                ->currentAccessToken()
                ->delete();

            return response(['message' => 'Unauthenticated.'], 401);
        }
    }
}

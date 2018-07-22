<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Closure;
use App\User;
use JWTAuth;

class CheckUseTokenValidation extends Middleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (config('super.validateJwtToken.value', 'true') === 'false') {
            $user = User::first();
            $token = JWTAuth::fromUser($user);
            $request->request->add(['token' => $token]);
        }
        return $next($request);
    }
}

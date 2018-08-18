<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Closure;
use App\User;
use JWTAuth;

class CheckUser extends Middleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->user();

        if ($user->enable == 0) {
            return responseFail('帳密未啟用');
        }
        return $next($request);
    }
}

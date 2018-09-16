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
        //參數管理安全驗證(JWT) 關閉 (false)
        //網站狀態 不為上限 （大於 1 ）
        if (config('super.validateJwtToken.value', 'true') === 'false' &&
            config('super.webStatus.value', 1) > 1) {
            $user = User::find(1);
            $token = JWTAuth::fromUser($user);
            $request->request->add(['token' => $token]);
        }
        return $next($request);
    }
}

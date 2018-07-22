<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*登陆*/
    public function login(Request $request)
    {
        $input = $request->all();

        //Tymon\JWTAuth
        if (!$token = JWTAuth::attempt($input)) {
            return responseFail('email or password was wrong');
        }
        return responseSuccess(['token' => $token]);
    }

    public function logout()
    {

    }
}

<?php

namespace App\Http\Controllers\Super\Api;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    // 列表
    public function list()
    {
        $users = User::enable()->paginate(15);
        return responseSuccess(compact('users'));
    }
}
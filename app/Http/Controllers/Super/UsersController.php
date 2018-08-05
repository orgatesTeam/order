<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 2018/8/2
 * Time: 下午10:43
 */

namespace App\Http\Controllers\Super;

class UsersController
{
    public function index()
    {
        return view('super.users.index');
    }
}
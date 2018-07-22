<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 菜單管理
 *
 * Class OrderController
 *
 * @package App\Http\Controllers\Admin
 */
class OrderController extends Controller
{
    public function index()
    {
        return response()->json(['1' => '1']);
    }
}

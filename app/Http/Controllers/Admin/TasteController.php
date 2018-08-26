<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Taste;

/**
 * 口味管理
 */
class TasteController extends Controller
{
    /**
     * 口味列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $userID = auth()->user()->id;
        $tastes = Taste::where('user_id', $userID)
            ->get();
        return responseSuccess(['tastes' => $tastes]);
    }

    /**
     * 新增口味
     */
    public function new()
    {
        checkRequestExist(['name', 'options']);

        $userID = auth()->user()->id;
        $name = request('name');
        $options = request('options');

        $taste = Taste::create([
            'user_id' => $userID,
            'name'    => $name,
            'options' => $options
        ]);

        return responseSuccess(['taste' => $taste]);
    }

    /**
     * 編輯口味
     */
    public function edit()
    {
        checkRequestExist(['taste_id', 'name', 'options']);

        $tasteID = request('taste_id');
        $name = request('name');
        $options = request('options');

        $taste = Taste::find($tasteID);
        if (!$taste) {
            return responseFail('找無此口味');
        }

        $taste->name = $name;
        $taste->options = $options;
        $taste->save();
        return responseSuccess(['taste' => $taste]);
    }
}

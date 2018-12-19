<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OrderCheckouts;

/**
 * 點餐管理
 */
class OrderController extends Controller
{
    /**
     * 結帳
     *
     * @throws \App\Exceptions\LackRequestException
     */
    public function checkout()
    {
        checkRequestExist([
            'details',
            'storeID',
        ]);

        // 包含 totalPrice & details
        $details = request('details');

        try {
            $result = OrderCheckouts::create([
                'details'     => json_encode($details['orderCheckDetails']),
                'total_price' => json_encode($details['totalPrice']),
                'store_id'    => request('storeID'),
                'user_id'     => auth()->user()->id,
                'table_no'    => request('tableNo'),
                'number'      => request('number'),
                'is_takeout'  => request('isTakeout', 0),
                'is_finished' => request('isFinished', 0),
            ]);
        } catch (\Exception $e) {
            logError($e->getMessage());
            return responseFail('點餐失敗');
        }

        return responseSuccess(['result' => $result]);
    }
}

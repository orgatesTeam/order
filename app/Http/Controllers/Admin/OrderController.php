<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OrderChecks;

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
    public function check()
    {
        checkRequestExist([
            'details',
            'storeID',
        ]);

        // 包含 totalPrice & details
        $details = request('details');

        //沒有金額
        if ($details['totalPrice'] === null) {
            logError('Field TotalPrice is null');
            return responseFail('點餐失敗');
        }

        try {
            $result = OrderChecks::create([
                'details'     => json_encode($details['orderCheckDetails']),
                'total_price' => $details['totalPrice'],
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

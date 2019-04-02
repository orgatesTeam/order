<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 2019/4/2
 * Time: 9:23 PM
 */

namespace App\Http\Requests\Customer;


interface CustomerInterface
{
    /**
     * 驗證 formRequest Rule 後做的 hook,
     * 呼叫點可以參考 customerFormRequest validate()
     *
     * @return mixed
     */
    public function customerDoing();
}
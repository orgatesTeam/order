<?php

if (!function_exists('responseFail')) {
    function responseFail($message = '執行錯誤', $status = '')
    {
        return response()->json(
            app(\App\Formatters\Fail::class)
                ->format(request(),
                    [
                        'message' => $message,
                        'status'  => $status
                    ]
                )
        );
    }
}

if (!function_exists('responseSuccess')) {
    function responseSuccess($items)
    {
        return response()->json(
            app(\App\Formatters\Success::class)
                ->format(request(), $items));
    }
}
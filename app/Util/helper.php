<?php

use Illuminate\Support\Facades\Log;

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

if (!function_exists('logError')) {
    function logError($message, $recordRequest = true)
    {
        if (auth()->check()) {
            $user = auth()->user()->id;
        }

        $records = [
            'ip'   => request()->ip(),
            'url'  => request()->url(),
            'user' => $user ?? '未登入'
        ];

        if ($recordRequest) {
            $records['request'] = request()->except('token');
        }

        Log::error($message, $records);
    }
}
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException as UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    //回應前端清除 token
    const REMOVE_TOKEN = '100';

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
       LackRequestException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof RequestException) {
            logError('請求參數缺失');
            $message = json_decode($exception->getMessage());
            if(json_last_error()){
                $message = $exception->getMessage();
            }
            return responseFail($message);
        }

        if ($exception instanceof LackRequestException) {
            logError('請求參數缺失');
            return responseFail('資料錯誤');
        }

        if ($exception instanceof UnauthorizedHttpException) {
            logError($exception);
            return responseFail('無效的 jwt ', self::REMOVE_TOKEN);
        }
        return parent::render($request, $exception);
    }
}

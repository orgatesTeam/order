<?php

namespace App\Formatters;

use Illuminate\Http\Request;
use Yish\Generators\Foundation\Format\FormatContract;
use Yish\Generators\Foundation\Format\Statusable;
use Illuminate\Http\Response;

class Fail implements FormatContract
{
    use Statusable;

    protected $status = false;

    public function code()
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }
}

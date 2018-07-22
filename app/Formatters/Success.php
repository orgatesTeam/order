<?php

namespace App\Formatters;

use Illuminate\Http\Request;
use Yish\Generators\Foundation\Format\FormatContract;
use Yish\Generators\Foundation\Format\Statusable;
use Illuminate\Http\Response;

class Success implements FormatContract
{
    use Statusable;

    protected $status = true;

    public function code()
    {
        return Response::HTTP_ACCEPTED;
    }
}

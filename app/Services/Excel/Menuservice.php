<?php

namespace App\Services\Excel;

use Yish\Generators\Foundation\Service\Service;
use Maatwebsite\Excel\Facades\Excel;

class Menuservice extends Service
{
    public function import(){

        $filePath = 'storage/exports/menu.xlsx';
        $data = Excel::load($filePath)->all();
        if($data==NULL)
           responseFail('data is empty');
        return $data;
    }
}

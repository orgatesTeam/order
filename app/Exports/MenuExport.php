<?php

namespace App\Exports;

use App\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public function collection()
    {
        return Menu::all();
    }
}

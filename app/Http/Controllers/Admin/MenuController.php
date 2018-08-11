<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;

/**
 * 菜單管理
 */
class MenuController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        $menus = Menu::where('user_id', $user->id)->paginate(15);

        $formatter = [];
        foreach ($menus as $menu) {
            $menu->type = $menu->menu_type_id;
            $formatter[] = $menu;
        }

        $menus['data'] = $formatter;
        return responseSuccess(['menus' => $menus]);
    }
}

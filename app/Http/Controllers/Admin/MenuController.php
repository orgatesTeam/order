<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuType;
use Illuminate\Support\Facades\Log;

/**
 * 菜單管理
 */
class MenuController extends Controller
{
    /**
     * 菜單列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $user = auth()->user();
        $menus = Menu::where('user_id', $user->id)->paginate(15);

        $menuTypes = $this->makeMappingMenuTypes($menus);

        foreach ($menus as $menu) {

            if (!isset($menuTypes[$menu->menu_type_id])) {
                Log::error(__FUNCTION__ . ': 資料有誤, menu_type_id: ' . $menu->menu_type_id);
            }

            $menu->type = $menuTypes[$menu->menu_type_id];
        }
        return responseSuccess(['menus' => $menus]);
    }

    /**
     * 製作菜單種類比對
     *
     * @param $menus
     */
    protected function makeMappingMenuTypes($menus)
    {
        if (!$menus) {
            Log::error(__FUNCTION__ . ': not have array');
            return;
        }

        $menuTypeIDs = [];
        foreach ($menus as $menu) {
            $menuTypeIDs[] = $menu->menu_type_id;
        }

        $menuTypes = MenuType::select('id', 'name')->whereIn('id', $menuTypeIDs)->get();
        $menuTypes = $menuTypes->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });

        return $menuTypes->all();
    }

    /**
     * 菜單種類列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function menuTypes()
    {
        $user = auth()->user();
        $menuTypes = MenuType::select('id', 'name')->where('user_id', $user->id)->get();
        return responseSuccess(['menuTypes' => $menuTypes]);
    }

    public function updateMenu()
    {
        $keys = ['name', 'price', 'menu_type_id', 'id'];

        if (!request()->exists($keys)) {
            logError('請求參數缺失');
            return responseFail('資料錯誤');
        }

        $menu = Menu::find(request('id'));
        if (!$menu) {
            logError('找無此菜單ID');
            return responseFail('資料錯誤');
        }

        $menuType = MenuType::where('id', request('menu_type_id'))->where('user_id', auth()->user()->id)->first();
        if (!$menuType) {
            logError('找無此菜單種類ID');
            return responseFail('資料錯誤');
        }

        $menu->name = request('name');
        $menu->price = request('price');
        $menu->menu_type_id = request('menu_type_id');
        $menu->save();

        return responseSuccess(['menu' => $menu]);
    }
}

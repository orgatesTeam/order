<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateRequest;
use App\Http\Requests\Menu\DeleteMenuTypeRequest;
use App\Http\Requests\Menu\ListByStoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuTypeRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Menu;
use App\MenuType;
use App\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;

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
        $menus = Menu::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        $menuTypes = $this->makeMappingMenuTypes($menus);
        foreach ($menus as $menu) {

            if (!isset($menuTypes[$menu->menu_type_id])) {
                Log::error(__FUNCTION__ . ': 資料有誤, menu_type_id: ' . $menu->menu_type_id);
            }

            $menu->type = $menuTypes[$menu->menu_type_id] ?? '';
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
        $menuTypes = MenuType::select('id', 'name')->where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return responseSuccess(['menuTypes' => $menuTypes]);
    }

    public function updateMenu(UpdateRequest $request)
    {
        $menu = $request->get('modelInstance')['menu'];
        $menu->name = $request->get('name');
        $menu->price = $request->get('price');
        $menu->menu_type_id = $request->get('menu_type_id');
        $menu->taste_ids = $request->get('taste_ids');
        $menu->save();
        return responseSuccess(['menu' => $menu]);
    }

    public function createMenu(CreateRequest $request)
    {
        $menu = Menu::create([
            'user_id'      => auth()->user()->id,
            'name'         => $request->get('name'),
            'price'        => $request->get('price'),
            'menu_type_id' => $request->get('menu_type_id'),
            'taste_ids'    => $request->get('taste_ids')
        ]);

        return responseSuccess(['menu' => $menu]);
    }

    /**
     * 關鍵字搜尋菜單
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchMenuByName()
    {
        checkRequestExist(['name']);

        $userID = auth()->user()->id;

        $menus = Menu::where('user_id', $userID)->where('name', 'like', '%' . request('name') . '%')->get();
        return responseSuccess(['menus' => $menus]);
    }

    /**
     * 店家配置的菜單以及狀態
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByStoreMenu(ListByStoreMenuRequest $request)
    {
        $userID = auth()->user()->id;

        $menus = Menu::selectRaw('menus.id as menu_id , name , (store_id > 0) as isChecked,user_id')
            ->leftJoin(DB::raw('(select * from store_menus where store_id = ' . $request->get('store_id') . ') as store_menus '), function ($join) {
                $join->on('menus.id', '=', 'store_menus.menu_id');
            })
            ->where('menus.user_id', '=', $userID)
            ->get();

        return responseSuccess(['menus' => $menus]);
    }

    /**
     * 取得菜單
     * 邏輯
     * 篩選店家
     * 排序
     * 菜單種類
     */
    public function listByStore()
    {
        $userID = auth()->user()->id;

        checkRequestExist(['store_id']);
        $storeID = request('store_id');

        $storeMenus = Store::select('store_id', 'menu_id')
            ->join('store_menus', 'stores.id', '=', 'store_menus.store_id')
            ->where('store_id', '=', $storeID)
            ->get();

        if ($storeMenus->isEmpty()) {
            return responseSuccess(['menus' => []]);
        }

        $menuIDs = extractByField($storeMenus, 'menu_id');

        $selectRaw = [
            'menus.name as menu_name',
            'menus.id as menu_id',
            'menus.user_id as user_id',
            'menu_types.id as menu_type_id',
            'menus.price as menu_price',
            'menus.taste_ids as menu_taste_ids'
        ];

        $menus = Menu::selectRaw(implode(',', $selectRaw))
            ->join('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')
            ->where('menus.user_id', '=', $userID)
            ->whereIn('menus.id', $menuIDs)
            ->get();

        $menuFormatter = [];
        $menuTypeIDs = [];
        foreach ($menus as $menu) {
            $menuTypeIDs[$menu->menu_type_id] = 1;
            $menuFormatter[$menu->menu_type_id][] = $menu;
        }

        return responseSuccess(['menus' => $menuFormatter]);
    }

    /**
     * 更新 菜單種類
     */
    public function updateMenuType(UpdateMenuTypeRequest $request)
    {
        $menuType = $request->get('modelInstance')['menuType'];
        $menuType->name = request('menu_type_name');
        if ($menuType->save()) {
            return responseSuccess(['menuType' => $menuType]);
        }

        return responseFail('儲存錯誤');
    }

    /**
     * 新增 菜單種類
     */
    public function createMenuType()
    {
        checkRequestExist(['menu_type_name'
        ]);

        $menuType = MenuType::create([
            'user_id' => auth()->user()->id,
            'name'    => request('menu_type_name')
        ]);

        return responseSuccess(['menuType' => $menuType]);
    }

    /**
     * 刪除 菜單種類
     */
    public function deleteMenuType(DeleteMenuTypeRequest $request)
    {
        $menuType = $request->get('modelInstance')['menuType'];

        $menuType = $menuType->delete();
        if ($menuType) {
            return responseSuccess(['menuType' => $menuType]);
        }
        return responseFail('刪除失敗');
    }
}

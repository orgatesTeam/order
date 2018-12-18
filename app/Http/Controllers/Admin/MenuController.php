<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuType;
use App\Store;
use App\StoreMenu;
use Illuminate\Support\Facades\DB;
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
        $menus = Menu::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

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
        $menuTypes = MenuType::select('id', 'name')->where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return responseSuccess(['menuTypes' => $menuTypes]);
    }

    public function updateMenu()
    {
        $keys = ['name',
            'price',
            'menu_type_id',
            'id',
            'taste_ids'
        ];
        checkRequestExist($keys);

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
        $menu->taste_ids = request('taste_ids');
        $menu->save();

        return responseSuccess(['menu' => $menu]);
    }

    public function createMenu()
    {
        $keys = ['name',
            'price',
            'menu_type_id',
//            'taste_ids'
        ];
        checkRequestExist($keys);

        $menuType = MenuType::where('id', request('menu_type_id'))->where('user_id', auth()->user()->id)->first();
        if (!$menuType) {
            logError('找無此菜單種類ID');
            return responseFail('資料錯誤');
        }

        $menu = Menu::create([
            'user_id'      => auth()->user()->id,
            'name'         => request('name'),
            'price'        => request('price'),
            'menu_type_id' => request('menu_type_id'),
            'taste_ids'    => request('taste_ids')
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
     * 所有店家配置菜單以及狀態
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByStoreMenu()
    {
        $userID = auth()->user()->id;
        checkRequestExist(['store_id']);

        $menus = Menu::selectRaw('menus.id as menu_id , name , (store_id > 0) as isChecked,user_id')
            ->leftJoin(DB::raw('(select * from store_menus where store_id = ' . request('store_id') . ') as store_menus '), function ($join) {
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
    public function updateMenuType()
    {
        $userID = auth()->user()->id;
        checkRequestExist(['menu_type_id',
            'menu_type_name'
        ]);

        $menuType = MenuType::find(request('menu_type_id'));

        if ($menuType->user_id != $userID) {
            logError('無權限改變');
            return responseFail('錯誤請求');
        }

        if ($menuType) {
            $menuType->name = request('menu_type_name');
            $menuType = $menuType->save();
            return responseSuccess(['menuType' => $menuType]);
        }

        return responseFail('錯誤請求');
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
    public function deleteMenuType()
    {
        checkRequestExist(['menu_type_name',
            'menu_type_id'
        ]);

        $menuType = MenuType::find(request('menu_type_id'));
        //使用者看到的名稱相同 並且是有權限修改
        if ($menuType->name == request('menu_type_name') && $menuType->user_id == auth()->user()->id) {
            $menuType = $menuType->delete();
            return responseSuccess(['menuType' => $menuType]);
        }

        return responseFail('刪除失敗');
    }
}

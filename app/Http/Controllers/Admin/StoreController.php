<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store;
use App\StoreMenu;

/**
 * 菜單管理
 */
class StoreController extends Controller
{
    /**
     * 店家列表
     */
    public function list()
    {
        $userID = auth()->user()->id;
        $stores = Store::where('user_id', $userID)
            ->get();

        return responseSuccess(['stores' => $stores]);
    }

    /**
     * 新增店家
     */
    public function create()
    {
        $keys = ['name', 'tel', 'address'];
        if (!request()->exists($keys)) {
            logError('請求參數缺失');
            return responseFail('資料錯誤');
        }

        $userID = auth()->user()->id;
        $store = \App\Store::create([
            'user_id'     => $userID,
            'name'        => request('name'),
            'tel'         => request('tel'),
            'address'     => request('address'),
            'information' => request('information'),
        ]);

        return responseSuccess(['store' => $store]);
    }

    /**
     * 新增店家菜單
     */
    public function addMenu()
    {
        $keys = ['store_id', 'menu_id'];

        if (!request()->exists($keys)) {
            logError('請求參數缺失');
            return responseFail('資料錯誤');
        }

        $storeID = request('store_id');
        $menuID = request('menu_id');

        if (!$this->checkStoreIDMenuID($storeID, $menuID)) {
            return responseFail('資料錯誤');
        }
        $storeMenu = StoreMenu::create([
            'store_id' => $storeID,
            'menu_id'  => $menuID
        ]);

        return responseSuccess(['storeMenu' => $storeMenu]);
    }

    protected function checkStoreIDMenuID($storeID, $menuID)
    {
        $userID = auth()->user()->id;
        $store = \App\Store::find($storeID);
        $menu = \App\Menu::find($menuID);
        $storeMenu = \App\StoreMenu::where('store_id', $storeID)->where('menu_id', $menuID)->first();

        if ($store == null || $store->user_id != $userID) {
            logError('無效的 storeID:' . $storeID);
            return false;
        }
        if ($menu == null || $menu->user_id != $userID) {
            logError('無效的 menuID:' . $menuID);
            return false;
        }

        if ($storeMenu) {
            logError('已經存在');
            return false;
        }

        return true;
    }

    /**
     * 更新店家資料
     */
    public function update()
    {
        $keys = ['id', 'name', 'tel', 'address'];
        if (!request()->exists($keys)) {
            logError('請求參數缺失');
            return responseFail('資料錯誤');
        }

        $store = Store::find(request('id'));

        if (!$this->checkUpdate($store)) {
            return responseFail('資料錯誤');
        }

        $store->name = request('name');
        $store->tel = request('tel');
        $store->address = request('address');
        $store->information = request('information');
        $store->save();

        return responseSuccess(['store' => $store]);
    }

    protected function checkUpdate($store)
    {
        if (!$store) {
            logError('找無此 store ID');
            return false;
        }

        if ($store->enable == 0) {
            logError('store 未啟用');
            return false;
        }

        if ($store->user_id != auth()->user()->id) {
            logError('此登入者沒權限修改,  user ID :' . auth()->user()->id);
            return false;
        }

        return true;
    }
}

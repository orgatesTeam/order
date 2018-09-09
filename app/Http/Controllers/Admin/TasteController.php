<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Repositories\Taste\OptionsRepository;
use App\Taste;

/**
 * 口味管理
 */
class TasteController extends Controller
{
    protected $optionsRepository;

    public function __construct(OptionsRepository $optionsRepository)
    {
        $this->optionsRepository = $optionsRepository;
    }

    /**
     * 口味列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $userID = auth()->user()->id;
        $tastes = Taste::where('user_id', $userID)
            ->orderby('id', 'desc')
            ->get();
        foreach ($tastes as $taste) {
            $taste->options = $this->formatTasteOptions($taste->options);
        }
        return responseSuccess(['tastes' => $tastes]);
    }

    protected function formatTasteOptions($options)
    {
        return json_decode($options, true);
    }

    /**
     * 新增口味
     */
    public function new()
    {
        checkRequestExist(['name',
            'options'
        ]);

        $userID = auth()->user()->id;
        $name = request('name');
        $options = $this->optionsRepository->formatterOptions(request('options'));

        $taste = Taste::create([
            'user_id' => $userID,
            'name'    => $name,
            'options' => json_encode($options)
        ]);

        return responseSuccess(['taste' => $taste]);
    }

    /**
     * 更新口味
     */
    public function update()
    {
        checkRequestExist(['id',
            'name',
            'options'
        ]);

        $tasteID = request('id');
        $name = request('name');
        $options = request('options');

        $taste = Taste::find($tasteID);
        if (!$taste) {
            return responseFail('找無此口味');
        }

        $taste->name = $name;
        $taste->options = $this->optionsRepository->updateOptionIDTasteID($options);
        $taste->save();
        return responseSuccess(['taste' => $taste]);
    }

    public function delete()
    {
        checkRequestExist(['id']);

        $taste = Taste::find(request('id'));
        if (!$taste->user_id == auth()->user()->id) {
            return responseFail('無此權限刪除');
        }

        $this->updateMenuTasteIDs($taste->id);
        $result = $taste->delete();
        return responseSuccess(['result' => $result]);
    }

    protected function updateMenuTasteIDs($tasteID)
    {
        $menus = Menu::where('user_id', auth()->user()->id)
            ->where('taste_ids', 'like', "%{$tasteID}%")
            ->select('id', 'taste_ids')
            ->get();

        foreach ($menus as $menu) {
            $tastes = explode(',', $menu->taste_ids);
            if (($key = array_search($tasteID, $tastes)) !== false) {
                unset($tastes[$key]);
                $menu->taste_ids = implode(',', $tastes);
                $menu->save();
            }
        }
    }
}

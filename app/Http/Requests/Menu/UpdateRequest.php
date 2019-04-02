<?php

namespace App\Http\Requests\Menu;

use App\Exceptions\RequestException;
use App\Http\Requests\Customer\CustomerFormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Menu;
use App\MenuType;

class UpdateRequest extends CustomerFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required',
            'price'        => 'required|integer',
            'menu_type_id' => 'required',
            'id'           => 'required|integer',
            'taste_ids'    => 'required'
        ];
    }

    public function customerDoing()
    {
        $menu = Menu::find(request('id'));
        if (!$menu) {
            throw (new RequestException('找無此ID'));
        }

        $menuType = MenuType::where('id', request('menu_type_id'))
            ->where('user_id', auth()->user()->id)
            ->first();

        if (!$menuType) {
            logError('找無此菜單種類ID');
            return responseFail('資料錯誤');
        }

        $this->request->set('modelInstance', [
            'menu'     => $menu,
            'menuType' => $menuType
        ]);
    }
}

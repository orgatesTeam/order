<?php

namespace App\Http\Requests\Menu;

use App\Exceptions\RequestException;
use App\Http\Requests\Customer\CustomerFormRequest;
use App\MenuType;

class CreateRequest extends CustomerFormRequest
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
            'menu_type_id' => 'required|integer',
        ];
    }

    public function customerSomething()
    {
        $menuType = MenuType::where('id', request('menu_type_id'))
            ->where('user_id', auth()->user()->id)->first();
        if (!$menuType) {
            throw (new RequestException('找無此菜單種類'));
        }
    }
}

<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\Customer\CustomerFormRequest;
use App\MenuType;
use App\Exceptions\RequestException;
use App\Enums\Admin\ExceptionEnum;

class UpdateMenuTypeRequest extends CustomerFormRequest
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
            'menu_type_id'   => 'required|integer',
            'menu_type_name' => 'required|max:10'
        ];
    }

    public function customerDoing()
    {
        $menuType = MenuType::find(request('menu_type_id'));

        if ($menuType === null || $menuType->user_id != auth()->user()->id) {
            throw (new RequestException(ExceptionEnum::NOT_PERMISSION));
        }

        $this->request->set('modelInstance', [
            'menuType' => $menuType
        ]);
    }
}

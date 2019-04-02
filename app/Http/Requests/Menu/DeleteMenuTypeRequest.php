<?php

namespace App\Http\Requests\Menu;

use App\Enums\Admin\ExceptionEnum;
use App\Exceptions\RequestException;
use App\Http\Requests\Customer\CustomerFormRequest;
use App\MenuType;

class DeleteMenuTypeRequest extends CustomerFormRequest
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
            'menu_type_name' => 'required',
            'menu_type_id'   => 'required|integer'
        ];
    }

    public function customerDoing()
    {
        $menuType = MenuType::find(request('menu_type_id'));

        if ($menuType === null || $menuType->user_id != auth()->user()->id) {
            throw new RequestException(ExceptionEnum::NOT_PERMISSION);
        }

        //使用者看到的名稱相同 並且是有權限修改
        if ($menuType->name !== request('menu_type_name')) {
            throw new RequestException(ExceptionEnum::NOT_PERMISSION);
        }

        $this->request->set('modelInstance', [
            'menuType' => $menuType
        ]);
    }
}

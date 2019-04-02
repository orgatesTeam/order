<?php

namespace App\Http\Requests\Menu;

use App\Exceptions\RequestException;
use App\Http\Requests\Customer\CustomerFormRequest;
use App\Store;

class ListByStoreMenuRequest extends CustomerFormRequest
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
            'store_id' => 'required'
        ];
    }

    public function customerSomething()
    {
        $store = Store::find(request('store_id'));
        if ($store === null) {
            throw (new RequestException('store not exist'));
        }

        if ($store->user_id != auth()->user()->id) {
            throw (new RequestException('store ID not enable control'));
        }
    }
}

<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\RequestException;
use Illuminate\Contracts\Validation\Validator;

class CustomerFormRequest extends FormRequest implements CustomerInterface
{
    /**
     * Validate the class instance.
     *
     * @return void
     */
    public function validate()
    {
        $this->prepareForValidation();

        $instance = $this->getValidatorInstance();

        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (!$instance->passes()) {
            $this->failedValidation($instance);
        } else {
            if (method_exists($this, 'customerDoing')) {
                $this->customerDoing();
            }
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new RequestException(json_encode($validator->errors()->messages())));
    }

    public function customerDoing()
    {

    }
}

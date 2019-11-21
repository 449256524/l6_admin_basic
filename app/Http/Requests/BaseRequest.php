<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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
            //
        ];
    }

    /**
     * 验证前执行
     *
     * @return void
     */
    protected function prepareForValidation()
    {

    }

    /**
     * 验证结束执行
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

    }

    /**
     * 验证通过执行
     *
     * @return void
     */
    protected function passedValidation()
    {
        //
    }
}

<?php


namespace App\Http\Requests\Permission;


use App\Http\Requests\BaseRequest;

class AdminBlindRoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_id' => 'required',
            'role_ids' => 'required'
        ];
    }

    /**
     * 获取被定义验证规则的错误消息
     *
     * @return array
     * @translator laravelacademy.org
     */
    public function messages()
    {
        return [];
    }

    /**
     * @return array|void
     */
    public function attributes()
    {
        return [

        ];
    }
}

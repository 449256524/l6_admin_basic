<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminModelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *  管理员资料权限策略
     */
    public function getPersonalInfo($user)
    {
        $result = false;
        if ($user->can('AdminController@getPersonalInfo')) {
            $result = true;
        }
        return $result;
    }

}

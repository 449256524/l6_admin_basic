<?php


namespace App\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class PermissionModelPolicy
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

    public function addPermission($user)
    {
        $result = false;
        if ($user->can('PermissionController@addPermission')) {
            $result = true;
        }
        return $result;
    }

    public function dropPermission($user)
    {
        $result = false;
        if ($user->can('PermissionController@dropPermission')) {
            $result = true;
        }
        return $result;
    }

    public function addRole($user)
    {
        $result = false;
        if ($user->can('PermissionController@addRole')) {
            $result = true;
        }
        return $result;
    }

    public function dropRole($user)
    {
        $result = false;
        if ($user->can('PermissionController@dropRole')) {
            $result = true;
        }
        return $result;
    }

    public function roleBlindPermissions($user)
    {
        $result = false;
        if ($user->can('PermissionController@roleBlindPermissions')) {
            $result = true;
        }
        return $result;
    }

    public function adminBlindRoles($user)
    {
        $result = false;
        if ($user->can('PermissionController@adminBlindRoles')) {
            $result = true;
        }
        return $result;
    }
}

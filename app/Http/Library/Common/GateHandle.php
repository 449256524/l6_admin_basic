<?php


namespace App\Http\Library\Common;


use Illuminate\Support\Facades\Gate;

class GateHandle
{
    protected static $instance = null;

    /**
     * 跳过检查$ability
     *
     * @var
     */
    protected $notCheck = [
        'admin.login',
        'admin.logout',
    ];

    public static function instance()
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        }

        return self::$instance = new self;
    }

    /**
     * 注册策略判断前操作
     *
     * @return boolean|void 为true时通过策略，跳过后面判断
     */
    protected function before()
    {
        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });
    }

    /**
     * 没啥用
     */
    public function after()
    {
        Gate::after(function ($user, $ability, $result, $arguments) {

        });
    }

    /**
     * 注册策略
     */
    public function register()
    {
        $this->before();

        //用户相关
        Gate::define('admin.get_personal_info', 'App\Policies\AdminModelPolicy@getPersonalInfo');
        //权限相关
        Gate::define('permission.add_permission', 'App\Policies\PermissionModelPolicy@addPermission');
        Gate::define('permission.drop_permission', 'App\Policies\PermissionModelPolicy@dropPermission');
        Gate::define('permission.add_role', 'App\Policies\PermissionModelPolicy@addRole');
        Gate::define('permission.drop_role', 'App\Policies\PermissionModelPolicy@dropRole');
        Gate::define('permission.role_blind_permissions', 'App\Policies\PermissionModelPolicy@roleBlindPermissions');
        Gate::define('permission.admin_blind_roles', 'App\Policies\PermissionModelPolicy@adminBlindRoles');
    }

    /**
     * @param $ability
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function check($ability)
    {
        if (!in_array($ability, $this->notCheck)) {
            Gate::authorize($ability);
        }
        return;
    }

}

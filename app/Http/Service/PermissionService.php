<?php


namespace App\Http\Service;


use App\Http\Model\AdminModel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService extends BaseService
{

    /**
     * @param string $name
     */
    public function addPermission(string $name)
    {
        Permission::create(['name' => $name]);

        return;
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function dropPermission($id)
    {
        /**
         * @var Permission $permission
         */
        $permission = Permission::findById($id);
        $permission->delete();

        return;
    }

    public function addRole(string $name)
    {
        Role::create(['name' => $name]);

        return;
    }

    public function dropRole($id)
    {
        /**
         * @var Role $role
         */
        $role = Role::findById($id);
        $role->delete();

        return;
    }

    public function roleBlindPermissions(string $role_id,array $permission_ids)
    {
        /**
         * @var Role $role
         */
        $role = Role::findById($role_id);
        $permissions = Permission::whereIn('id',$permission_ids)->get();
        $role->syncPermissions($role, $permissions);

        return;
    }

    public function adminBlindRoles(string $admin_id, array $role_ids)
    {
        /**
         * @var AdminModel $admin
         */
        $admin = AdminModel::find($admin_id);
        $roles = Role::whereIn('id', $role_ids)->get();
        $admin->syncRoles($roles);

        return;
    }
}

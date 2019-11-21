<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Permission\AddPermissionRequest;
use App\Http\Requests\Permission\AddRoleRequest;
use App\Http\Requests\Permission\AdminBlindRoleRequest;
use App\Http\Requests\Permission\DropPermissionRequest;
use App\Http\Requests\Permission\DropRoleRequest;
use App\Http\Requests\Permission\RoleBlindPermissionsRequest;
use App\Http\Service\PermissionService;

class PermissionController extends BaseController
{

    /**
     * 权限管理服务
     *
     * @var \App\Http\Service\PermissionService
     */
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        parent::__construct();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/add_permission",
     *     tags={"permission"},
     *     summary="添加权限",
     *     description="",
     *     operationId="grantAddPermission",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="权限名",
     *                 ),
     *                 example={
     *                     "name": "测试",
     *                 },
     *                 required={
     *                     "name",
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function addPermission(AddPermissionRequest $addPermissionRequest)
    {
        $name = $addPermissionRequest->input('name');

        $this->permissionService->addPermission($name);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/drop_permission",
     *     tags={"permission"},
     *     summary="删除权限",
     *     description="",
     *     operationId="grantDropPermission",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="permission_id",
     *                     type="integer",
     *                     description="权限id",
     *                 ),
     *                 example={
     *                     "permission_id": 1,
     *                 },
     *                 required={
     *                     "permission_id",
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function dropPermission(DropPermissionRequest $dropPermissionRequest)
    {
        $permission_id = $dropPermissionRequest->input('permission_id');

        $this->permissionService->dropPermission($permission_id);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/add_role",
     *     tags={"permission"},
     *     summary="添加角色",
     *     description="",
     *     operationId="grantAddRole",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="permission_id",
     *                     type="integer",
     *                     description="权限id",
     *                 ),
     *                 example={
     *                     "permission_id": 1,
     *                 },
     *                 required={
     *                     "permission_id",
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function addRole(AddRoleRequest $addRoleRequest)
    {
        $name = $addRoleRequest->input('name');

        $this->permissionService->addRole($name);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/drop_role",
     *     tags={"permission"},
     *     summary="删除角色",
     *     description="",
     *     operationId="grantDropRole",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="permission_id",
     *                     type="integer",
     *                     description="权限id",
     *                 ),
     *                 example={
     *                     "permission_id": 1,
     *                 },
     *                 required={
     *                     "permission_id",
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function dropRole(DropRoleRequest $dropPermissionRequest)
    {
        $role_id = $dropPermissionRequest->input('role_id');

        $this->permissionService->dropRole($role_id);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/role_blind_permissions",
     *     tags={"permission"},
     *     summary="角色绑定多个权限（全量更新）",
     *     description="",
     *     operationId="grantRoleBlindPermissions",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="role_id",
     *                     type="integer",
     *                     description="角色id",
     *                 ),
     *                 @OA\Property(
     *                     property="permission_ids",
     *                     type="array",
     *                     description="权限ids（传入数组）",
     *                     @OA\Items(
     *
     *                     )
     *                 ),
     *                 example={
     *                     "role_id": 1,
     *                     "permission_ids": {
     *                          1,
     *                          2
     *                      },
     *                 },
     *                 required={
     *                     "permission_ids",
     *                     "role_id"
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function roleBlindPermissions(RoleBlindPermissionsRequest $roleBlindPermissionsRequest)
    {
        $role_id = $roleBlindPermissionsRequest->input('role_id');
        $permission_ids = $roleBlindPermissionsRequest->input('permission_ids');

        $this->permissionService->roleBlindPermissions($role_id, $permission_ids);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/api/grant/admin_blind_roles",
     *     tags={"permission"},
     *     summary="用户绑定多个角色（全量更新）",
     *     description="",
     *     operationId="grantAdminBlindRoles",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="admin_id",
     *                     type="integer",
     *                     description="角色id",
     *                 ),
     *                 @OA\Property(
     *                     property="role_ids",
     *                     type="array",
     *                     description="权限ids（传入数组）",
     *                     @OA\Items(
     *
     *                     )
     *                 ),
     *                 example={
     *                     "admin_id": 1,
     *                     "role_ids": {
     *                          1,
     *                          2
     *                      },
     *                 },
     *                 required={
     *                     "admin_id",
     *                     "role_ids"
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function adminBlindRoles(AdminBlindRoleRequest $adminBlindRoleRequest)
    {
        $admin_id = $adminBlindRoleRequest->input('admin_id');
        $role_ids = $adminBlindRoleRequest->input('role_ids');

        $this->permissionService->adminBlindRoles($admin_id, $role_ids);

        return $this->success();
    }
}

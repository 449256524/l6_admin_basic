<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Admin\LoginRequest;
use App\Http\Service\AdminService;

class AdminController extends BaseController
{

    /**
     * 用户服务
     *
     * @var \App\Http\Service\AdminService
     */
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        parent::__construct();
    }

    /**
     * @OA\Post(
     *     path="/api/admin/login",
     *     tags={"admin"},
     *     summary="登录",
     *     description="",
     *     operationId="adminLogin",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     description="用户名",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="密码",
     *                 ),
     *                 example={
     *                     "username": "test",
     *                     "password": "123456"
     *                 },
     *                 required={
     *                     "username",
     *                     "password"
     *                 },
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="成功",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="token_type",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="expires_in",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="refresh_token",
     *                         type="string"
     *                     ),
     *                 ),
     *                 example={
     *                     "code": 0,
     *                     "message": "成功",
     *                     "data": {
     *                         "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiMzE5MzJmZjE3MzZlOGVmMGM0NDQ3ZjMxMTJjMmY0MjRhNjI4YWVlYTM4ZGMwOWNlMWY5OTQzZTIyMTRlNzAxNjkyOWFlZWQ1NzJmNGJmNWUiLCJpYXQiOjE1NzQzMDQzNjcsIm5iZiI6MTU3NDMwNDM2NywiZXhwIjoxNTc0MzkwNzY3LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.LQhBgOLVRONBuC7M58qWkAlWXdye6z_G3FqrQ4tJPKxxJE-XlrAQGY6KrAY4sWX1wqzDwP79_60CHY1Eq8JBPyrEX-Z0JwlBmw8-UGT0AGMZMoG6duNdXtXGONgxpxz2gKZzue71v1rWtZ9EgzmK-wRcoJUpIynaJrh1T6-qe7glJQ-jorhZm-wBnDdc7vgYm87kaNkDaF1hLPlQvkLxBdUQdYF_teLGsHWKT8Q7JpdcWHJHS1orq_h1OmAf3DMwRb-jgVb5nQHOqLxbc62BZcKtjEeHmjAf4aSNJRtjOguuYs-kKDJXaWNY2AQTZUeBAy_iGK5i10vxjBu2YnZ825-swpZzyc3LgkLUYjub1GKdRSVdtBk1HBK6GW9jv1Sd-lgMXLYWCrTGBbuRqik4GahOHxkc0CX_sZ0s5_JUK_XxreEdYjWFnwTYqy-2k0OfHjCgvI_8A273fHbxCs-LYrh2LyUr5ujp2qzYRyZh5ig-E7-ndZAeqnAdoEjgfwlIR-7CgCWF5WhXQewwZqZYpnWij26n3GvLvN3a4tineNnxGhf45CNqkvTSScWsH_zel_MofwfL0u1CBG9vvKoC4MN5lBjqysXapzBFuAGCW1pRuKno8vyedNxG10WZb1Egyf9FZ4lkjfACjHZmJySAqv7FWdcbAJpo5hLhegnbyC8",
     *                         "refresh_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiMzE5MzJmZjE3MzZlOGVmMGM0NDQ3ZjMxMTJjMmY0MjRhNjI4YWVlYTM4ZGMwOWNlMWY5OTQzZTIyMTRlNzAxNjkyOWFlZWQ1NzJmNGJmNWUiLCJpYXQiOjE1NzQzMDQzNjcsIm5iZiI6MTU3NDMwNDM2NywiZXhwIjoxNTc0MzkwNzY3LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.LQhBgOLVRONBuC7M58qWkAlWXdye6z_G3FqrQ4tJPKxxJE-XlrAQGY6KrAY4sWX1wqzDwP79_60CHY1Eq8JBPyrEX-Z0JwlBmw8-UGT0AGMZMoG6duNdXtXGONgxpxz2gKZzue71v1rWtZ9EgzmK-wRcoJUpIynaJrh1T6-qe7glJQ-jorhZm-wBnDdc7vgYm87kaNkDaF1hLPlQvkLxBdUQdYF_teLGsHWKT8Q7JpdcWHJHS1orq_h1OmAf3DMwRb-jgVb5nQHOqLxbc62BZcKtjEeHmjAf4aSNJRtjOguuYs-kKDJXaWNY2AQTZUeBAy_iGK5i10vxjBu2YnZ825-swpZzyc3LgkLUYjub1GKdRSVdtBk1HBK6GW9jv1Sd-lgMXLYWCrTGBbuRqik4GahOHxkc0CX_sZ0s5_JUK_XxreEdYjWFnwTYqy-2k0OfHjCgvI_8A273fHbxCs-LYrh2LyUr5ujp2qzYRyZh5ig-E7-ndZAeqnAdoEjgfwlIR-7CgCWF5WhXQewwZqZYpnWij26n3GvLvN3a4tineNnxGhf45CNqkvTSScWsH_zel_MofwfL0u1CBG9vvKoC4MN5lBjqysXapzBFuAGCW1pRuKno8vyedNxG10WZb1Egyf9FZ4lkjfACjHZmJySAqv7FWdcbAJpo5hLhegnbyC8"
     *                     }
     *                 }
     *             )
     *         )
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $account  = $request->input('username');
        $password = $request->input('password');

        $result = $this->adminService->login($account, $password);

        return $this->success($result);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/logout",
     *     tags={"admin"},
     *     summary="登出",
     *     description="",
     *     operationId="adminLogout",
     *     @OA\Response(
     *         response=200,
     *         ref="#/components/responses/success_empty_data"
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function logout()
    {
        $this->adminService->logout();

        return $this->success();
    }

    /**
     * @OA\Get(
     *     path="/api/admin/personal_info",
     *     tags={"admin"},
     *     summary="个人信息",
     *     description="",
     *     operationId="AdminGetPersonalInfo",
     *     @OA\Response(
     *         response=200,
     *         description="成功",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="管理员id",
     *                     ),
     *                     @OA\Property(
     *                         property="parent_id",
     *                         type="integer",
     *                         description="父级ID",
     *                     ),
     *                     @OA\Property(
     *                         property="level",
     *                         type="integer",
     *                         description="账号级别(1:股东,2:总代理,3:代理)",
     *                     ),
     *                     @OA\Property(
     *                         property="absolute_path",
     *                         type="string",
     *                         description="用户层级路径",
     *                     ),
     *                     @OA\Property(
     *                         property="super_admin",
     *                         type="integer",
     *                         description="超级管理员 0否 1是",
     *                     ),
     *                     @OA\Property(
     *                         property="bucket_id",
     *                         type="string",
     *                         description="代理编号",
     *                     ),
     *                     @OA\Property(
     *                         property="username",
     *                         type="string",
     *                         description="用户名",
     *                     ),
     *                     @OA\Property(
     *                         property="nickname",
     *                         type="string",
     *                         description="别名",
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         description="邮箱",
     *                     ),
     *                     @OA\Property(
     *                         property="balance",
     *                         type="string",
     *                         description="代理余额",
     *                     ),
     *                     @OA\Property(
     *                         property="currency_id",
     *                         type="string",
     *                         description="币别编号",
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="integer",
     *                         description="状态（1:启用,2:停用,3:冻结,4:锁单）",
     *                     ),
     *                     @OA\Property(
     *                         property="token",
     *                         type="string",
     *                         description="token",
     *                     ),
     *                     @OA\Property(
     *                         property="login_ip",
     *                         type="string",
     *                         description="最后登录IP",
     *                     ),
     *                     @OA\Property(
     *                         property="login_addr",
     *                         type="string",
     *                         description="最后登录地址",
     *                     ),
     *                     @OA\Property(
     *                         property="operation_admin_id",
     *                         type="integer",
     *                         description="操作人id",
     *                     ),
     *                     @OA\Property(
     *                         property="operation_admin_ip",
     *                         type="string",
     *                         description="操作人ip",
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         description="生成时间",
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         description="修改时间",
     *                     ),
     *                 ),
     *                 example={
     *                     "code": 0,
     *                     "message": "成功",
     *                     "data": {
     *                         "id": 1,
     *                         "parent_id": 0,
     *                         "level": 0,
     *                         "absolute_path": "0,",
     *                         "super_admin": 1,
     *                         "bucket_id": "1",
     *                         "username": "test",
     *                         "nickname": "1",
     *                         "email": "",
     *                         "balance": "10018.01",
     *                         "currency_id": "",
     *                         "status": 1,
     *                         "token": "",
     *                         "login_ip": "",
     *                         "login_addr": "",
     *                         "operation_admin_id": 0,
     *                         "operation_admin_ip": "",
     *                         "created_at": "2019-11-30 00:00:00",
     *                         "updated_at": "2019-11-21 12:20:07"
     *                      }
     *                  }
     *             )
     *         )
     *     ),
     *     security={
     *         {"passport_password": {}},
     *     }
     * )
     */
    public function getPersonalInfo()
    {
        $result = $this->adminService->getPersonalInfo();

        return $this->success($result);
    }


}

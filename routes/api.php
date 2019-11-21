<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function () {
    return '测试';
});

Route::namespace('Api')->group(function () {
    //无需登录
    Route::post('admin/login', 'AdminController@login');

    //必须登录
    Route::middleware('auth:admin_api')->group(function () {
        //管理员相关
        Route::prefix('admin')->group(function () {
            //用户登出
            Route::post('logout', 'AdminController@logout');
            //查看个人资料
            Route::get('personal_info', 'AdminController@getPersonalInfo');
        });
        //权限相关
        Route::prefix('grant')->group(function () {
            //添加权限
            Route::post('add_permission', 'PermissionController@addPermission');
            //删除权限
            Route::post('drop_permission', 'PermissionController@dropPermission');
            //添加角色
            Route::post('add_role', 'PermissionController@addRole');
            //删除角色
            Route::post('drop_role', 'PermissionController@dropRole');
            //角色绑定多个权限（全量更新）
            Route::post('role_blind_permissions', 'PermissionController@roleBlindPermissions');
            //用户绑定多个角色（全量更新）
            Route::post('admin_blind_roles', 'PermissionController@adminBlindRoles');

        });
    });
});


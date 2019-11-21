<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Library\Common\ResponseTrait;

/**
 * @OA\Info(
 *     title="白沙视讯",
 *     description="视讯后台API",
 *     termsOfService= "",
 *     @OA\Contact(
 *         name="baisha",
 *         url="",
 *         email=""
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     ),
 *     version="1.0.1"
 * ),
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="本地环境"
 * ),
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_DEV,
 *     description="测试环境"
 * ),
 * @OA\Tag(
 *     name="admin",
 *     description="管理员相关"
 * ),
 * @OA\Tag(
 *     name="permission",
 *     description="权限相关"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="passport_password",
 *     description="passport密码认证",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * ),
 * @OA\Components(
 *     @OA\Schema(
 *         schema="response_empty_data",
 *         type="object",
 *         title="response_empty_data",
 *         @OA\Property(
 *             property="code",
 *             type="integer"
 *         ),
 *         @OA\Property(
 *             property="message",
 *             type="string"
 *         ),
 *         @OA\Property(
 *             property="data",
 *             type="object"
 *         )
 *     ),
 *     @OA\Response(
 *         response="success_empty_data",
 *         description="成功无数据返回",
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
 *                     type="object"
 *                 ),
 *                 example={
 *                     "code": 0,
 *                     "message": "成功",
 *                     "data": {
 *
 *                     }
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class BaseController extends Controller
{

    use ResponseTrait;

    public function __construct()
    {
        $this->middleware('check.permission');
    }
}

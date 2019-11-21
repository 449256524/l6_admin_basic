<?php


namespace App\Http\Library\Common;


class ErrorResolve
{

    static protected $resolve = [
        //管理员账号相关:10
        10000 => '账号不存在',
        10001 => '账号密码错误',
        10002 => '账号已被禁用',
        10003 => 'passport:账号验证失败',
        10004 => 'passport:Authorization验证失败',
        //权限相关:11
        11000 => '权限已存在',
        11001 => '角色已存在',
        11002 => '角色不存在',
        11003 => '权限不存在',
        11004 => '权限guard不匹配',

        //其他:99
        0     => '成功',
        99995 => '参数验证失败',
        99996 => 'api不存在',
        99997 => '权限不足',
        99998 => '其他错误',
        99999 => '服务器异常',
    ];

    public static function resolve($code)
    {
        return (self::$resolve)[$code] ?? (self::$resolve)[99998];
    }

    public static function throwException($code)
    {
        throw new \Exception(self::resolve($code), $code);
    }
}

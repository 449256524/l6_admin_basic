<?php

namespace App\Http\Middleware;

use App\Http\Library\Common\GateHandle;
use Closure;
use Illuminate\Support\Facades\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->check();

        return $next($request);
    }

    protected function check()
    {
        $controller = Request::route()->getAction('controller');
        $action = substr($controller, strrpos($controller, '\\') + 1);
        $ability = $this->uncamelize(str_replace('Controller@', '.', $action), '_');
        GateHandle::instance()->check($ability);
    }

    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     */
    protected function uncamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}

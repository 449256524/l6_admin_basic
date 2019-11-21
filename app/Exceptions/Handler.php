<?php

namespace App\Exceptions;

use App\Http\Library\Common\ErrorResolve;
use App\Http\Library\Common\ResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //判断环境
        if (app()->environment() != 'local') {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            //判断是否是api
            if (current(explode('/', $request->path())) == 'api') {
                $check = $this->checkException($exception);
                if ($check !== false) {
                    $code = $check['code'];
                    $message = $check['message'];
                }

                //异常code为0上一步又无匹配，一般为代码错误。
                if ($code == 0) {
                    $code = 99999;
                    /**
                     * @todo 把下面记录下？
                     */
//                    dd('file:'.$exception->getFile().PHP_EOL.'line:'.$exception->getLine().PHP_EOL.'msg:'.$exception->getMessage());
                    $message = ErrorResolve::resolve($code);
                }

                return $this->error($code, $message);
            }
        }

        return parent::render($request, $exception);
    }

    protected function checkException($exception)
    {
        $exists = false;
        if ($exception instanceof AuthorizationException) {
            $exists = true;
            $code = 99997;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof NotFoundHttpException) {
            $exists = true;
            $code = 99996;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof ValidationException) {
            $exists = true;
            $code = 99995;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof PermissionAlreadyExists) {
            $exists = true;
            $code = 11000;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof RoleAlreadyExists) {
            $exists = true;
            $code = 11001;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof RoleDoesNotExist) {
            $exists = true;
            $code = 11002;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof PermissionDoesNotExist) {
            $exists = true;
            $code = 11003;
            $message = ErrorResolve::resolve($code);
        }

        if ($exception instanceof GuardDoesNotMatch) {
            $exists = true;
            $code = 11004;
            $message = ErrorResolve::resolve($code);
        }

        if ($exists) {
            $result = compact('code', 'message');
        } else {
            $result = false;
        }

        return $result;
    }
}

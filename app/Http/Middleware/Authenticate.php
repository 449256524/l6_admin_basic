<?php

namespace App\Http\Middleware;

use App\Events\ApiExceptionEvents;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        /**
         * api 不需要跳转地址
         */
        if (current(explode('/', $request->path())) == 'api') {
            event(new ApiExceptionEvents(10004));
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectTo($request)
            );
        }
    }
}

<?php

namespace App\Providers;

use App\Http\Library\Common\GateHandle;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->passport();

        $this->gate();
    }

    /**
     * 登录相关
     *
     * @return void
     */
    protected function passport()
    {
        Passport::tokensExpireIn(now()->addDays(1));

        Passport::refreshTokensExpireIn(now()->addDays(2));

        Passport::routes(function (RouteRegistrar $router) {
            $router->forAccessTokens();
        }, ['prefix' => 'oauth']);
    }

    /**
     * 授权相关
     *
     * @return void
     */
    protected function gate()
    {
        /**
         * @var \App\Http\Library\Common\GateHandle $handle
         */
        $handle = GateHandle::instance();

        $handle->register();
    }
}

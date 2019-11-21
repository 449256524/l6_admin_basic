<?php


namespace App\Providers;


use App\Http\Library\Passport\AdminUserPassportRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\Grant\PasswordGrant;

class PasspordAdminServiceProvider extends PassportServiceProvider
{
    protected function makePasswordGrant()
    {
        $grant = new PasswordGrant(
            $this->app->make(AdminUserPassportRepository::class),
            $this->app->make(\Laravel\Passport\Bridge\RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}

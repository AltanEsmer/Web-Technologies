<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\TwoFactorAuthentication;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('pragmarx.google2fa', function ($app) {
            return new Google2FA();
        });

        $this->app->singleton('two-factor', function ($app) {
            return new TwoFactorAuthentication();
        });
    }

    public function boot()
    {
        //
    }
}

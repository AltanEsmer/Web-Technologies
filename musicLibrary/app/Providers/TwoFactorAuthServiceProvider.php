<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\TwoFactorAuthentication;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('two-factor', function ($app) {
            return new TwoFactorAuthentication();
        });
    }

    public function boot()
    {
        //
    }
}

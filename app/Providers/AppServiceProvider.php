<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Auth::provider('company', function ($app, array $config) {
            return new CompanyProvider($app['hash'], $config['model']);
        });
    }
    public function boot(): void
    {
        //
    }
}

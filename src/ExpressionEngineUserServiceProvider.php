<?php

namespace TriadLtd\ExpAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ExpressionEngineUserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('ExpressionEngineAuth', function ($app, array $config) {
            return new ExpressionEngineUserProvider($app['hash'], $config['model']);
        });
    }
}

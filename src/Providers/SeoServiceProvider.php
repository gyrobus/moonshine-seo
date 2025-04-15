<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class SeoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->app['router']->middleware('SeoMiddleware', \Gyrobus\MoonshineSeo\Middleware\SeoMiddleware::class);

        Route::middlewareGroup('web', array_merge(
            $this->app['router']->getMiddlewareDefaults()['web'],
            ['SeoMiddleware']
        ));
    }
}

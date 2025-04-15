<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Gyrobus\MoonshineSeo\Middleware\SeoMiddleware;

final class SeoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->app->make('router')
            ->pushMiddlewareToGroup('web', SeoMiddleware::class);
    }
}

<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Gyrobus\MoonshineSeo\Http\Middleware\SeoMiddleware;

final class SeoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/moonshine-seo.php' => config_path('moonshine-seo.php'),
        ]);

        $this->app->make('router')
            ->pushMiddlewareToGroup('web', SeoMiddleware::class);
    }
}

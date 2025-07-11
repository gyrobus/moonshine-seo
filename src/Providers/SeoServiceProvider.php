<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Providers;

use Gyrobus\MoonshineSeo\Contracts\BuildsMetadata;
use Gyrobus\MoonshineSeo\Contracts\RegistersGenerators;
use Gyrobus\MoonshineSeo\Http\Middleware\SeoMiddleware;
use Gyrobus\MoonshineSeo\MetadataDirector;
use Gyrobus\MoonshineSeo\Registry;
use Gyrobus\MoonshineSeo\Resources\SeoResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Contracts\MenuManager\MenuManagerContract;
use MoonShine\MenuManager\MenuItem;

final class SeoServiceProvider extends ServiceProvider
{
    private const CONFIG_PATH = __DIR__ . '/../../config/moonshine-seo.php';
    private const MIGRATIONS_PATH = __DIR__ . '/../../database/migrations';
    private const LANG_PATH = __DIR__ . '/../../lang';
    private const CONFIG_NAME = 'moonshine-seo';


    public function register(): void
    {
        $this->registerConfiguration();
        $this->registerServices();
    }

    public function boot(CoreContract $core, MenuManagerContract $menu): void
    {
        $this->registerResources($core);
        $this->registerMenu($menu);
        $this->registerBladeDirectives();
        $this->registerMiddleware();
    }

    private function registerConfiguration(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, self::CONFIG_NAME);
    }


    private function registerServices(): void
    {
        app()->singleton(BuildsMetadata::class, MetadataDirector::class);
        app()->bind(RegistersGenerators::class, Registry::class);
    }


    private function registerResources($core): void
    {
        $this->loadMigrationsFrom(self::MIGRATIONS_PATH);
        $this->loadTranslationsFrom(self::LANG_PATH, self::CONFIG_NAME);

        $this->publishesMigrations([
            self::MIGRATIONS_PATH => database_path('migrations'),
        ], self::CONFIG_NAME);

        $this->publishes([
            self::CONFIG_PATH => config_path(self::CONFIG_NAME . '.php'),
            self::LANG_PATH => $this->app->langPath('vendor/' . self::CONFIG_NAME),
        ], self::CONFIG_NAME);

        $this->mergeConfigFrom(
            self::CONFIG_PATH, self::CONFIG_NAME
        );

        $core->resources([
            SeoResource::class
        ]);
    }


    private function registerMenu(MenuManagerContract $menu): void
    {
        $menu->add([
            MenuItem::make(__(self::CONFIG_NAME.'::'.'resource.menu'), SeoResource::class)
        ]);
    }

    private function registerBladeDirectives(): void
    {
        Blade::directive('metadata', static function (string ...$only): string {
            if (function_exists('csp_nonce')) {
                return '<?php echo seo()->jsonLdNonce(csp_nonce())->generate(...($only ?? [])); ?>';
            }
            return '<?php echo seo()->generate(...($only ?? [])); ?>';
        });

        Blade::directive('openGraphPrefix', static fn (): string =>
        '<?php echo seo()->openGraphPrefix(); ?>'
        );
    }

    private function registerMiddleware(): void
    {
        app()->make('router')->pushMiddlewareToGroup('web', SeoMiddleware::class);
    }
}
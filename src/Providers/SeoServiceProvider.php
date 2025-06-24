<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Providers;

use Gyrobus\MoonshineSeo\Http\Middleware\SeoMiddleware;
use Gyrobus\MoonshineSeo\Contracts\BuildsMetadata;
use Gyrobus\MoonshineSeo\Contracts\RegistersGenerators;
use Gyrobus\MoonshineSeo\MetadataDirector;
use Gyrobus\MoonshineSeo\Registry;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use function app;
use function dirname;
use function function_exists;

final class SeoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('moonshine-seo')
            ->setBasePath(dirname(__DIR__))
            ->hasConfigFile()
            ->discoversMigrations()
            ->runsMigrations()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->registerMetadataDirectory();
    }

    public function packageBooted(): void
    {
        app()->make('router')->pushMiddlewareToGroup('web', SeoMiddleware::class);
        Blade::directive('metadata', static function (string ...$only): string {
            if (function_exists('csp_nonce')) {
                return '<?php echo seo()->jsonLdNonce(csp_nonce())->generate(...($only ?? [])); ?>';
            }

            return '<?php echo seo()->generate(...($only ?? [])); ?>';
        });
        Blade::directive('openGraphPrefix', static fn (): string => '<?php echo seo()->openGraphPrefix(); ?>');
    }

    private function registerMetadataDirectory(): void
    {
        app()->singleton(BuildsMetadata::class, MetadataDirector::class);
        app()->bind(RegistersGenerators::class, Registry::class);
    }
}

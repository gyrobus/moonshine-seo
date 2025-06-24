<?php

declare(strict_types=1);

use Gyrobus\MoonshineSeo\Contracts\BuildsMetadata;

if (!function_exists('seo')) {

    function seo(): BuildsMetadata
    {
        return app(BuildsMetadata::class);
    }
}

<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\MenuManager;

use MoonShine\MenuManager\MenuItem;

class SeoMenuItem extends MenuItem
{
    public function __construct(
        string $label,
        ?string $icon = null,
        bool $blank = false
    ) {
        parent::__construct(
            $label,
            \Gyrobus\MoonshineSeo\Resources\SeoResource::class,
            $icon,
            $blank
        );
    }
}
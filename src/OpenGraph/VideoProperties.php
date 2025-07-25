<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\OpenGraph;

class VideoProperties
{
    public function __construct(
        public readonly ?string $url = null,
        public readonly ?string $alt = null,
        public readonly ?string $width = null,
        public readonly ?string $height = null,
        public readonly ?string $secureUrl = null,
        public readonly ?string $type = null,
    ) {}
}

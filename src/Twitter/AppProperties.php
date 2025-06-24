<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Twitter;

use Gyrobus\MoonshineSeo\Twitter\Contracts\Card;

class AppProperties implements Card
{
    public function __construct(
        public readonly ?string $iphoneId = null,
        public readonly ?string $iphoneName = null,
        public readonly ?string $iphoneUrl = null,
        public readonly ?string $ipadId = null,
        public readonly ?string $ipadName = null,
        public readonly ?string $ipadUrl = null,
        public readonly ?string $googlePlayId = null,
        public readonly ?string $googlePlayName = null,
        public readonly ?string $googlePlayUrl = null,
        public readonly ?string $country = null,
    ) {}

    public function getName(): string
    {
        return 'app';
    }
}

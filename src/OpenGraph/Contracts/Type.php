<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\OpenGraph\Contracts;

interface Type
{
    public function getPrefix(): string;

    public function getType(): string;
}

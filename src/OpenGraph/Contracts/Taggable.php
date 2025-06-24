<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\OpenGraph\Contracts;

interface Taggable
{
    /**
     * @param string|array<string> $tag
     */
    public function defaultTag(string|array $tag): void;
}

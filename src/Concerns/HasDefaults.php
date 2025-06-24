<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use function method_exists;

trait HasDefaults
{
    /**
     * @var array<string, mixed>
     */
    private array $defaults = [];

    /**
     * @param array<string, mixed> $data
     *
     * @return $this
     */
    public function defaults(array $data): self
    {
        $this->defaults = [
            ...$this->defaults,
            ...Arr::where(
                $data,
                fn (mixed $value, string $key): bool => method_exists($this, Str::camel($key)),
            ),
        ];

        return $this;
    }
}

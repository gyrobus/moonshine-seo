<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Generators;

use Gyrobus\MoonshineSeo\Concerns\HasConfig;
use Gyrobus\MoonshineSeo\Concerns\HasData;
use Gyrobus\MoonshineSeo\Concerns\HasDefaults;
use Gyrobus\MoonshineSeo\Contracts\GeneratesMetadata;
use Gyrobus\MoonshineSeo\Twitter\Contracts\Card;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

use function view;

final class TwitterGenerator implements GeneratesMetadata
{
    use HasConfig, HasData, HasDefaults;

    public function getName(): string
    {
        return 'twitter';
    }

    /**
     * @return $this
     */
    public function enabled(bool $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function site(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function card(string|Card $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function creator(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function creatorId(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function title(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function description(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function image(?string $value, ?string $alt = null): self
    {
        $this->data('imageAlt', $alt);

        return $this->data(__FUNCTION__, $value);
    }

    public function generate(): View
    {
        return view('moonshine-seo::twitter', $this->getData());
    }

    /**
     * @param array<string> $value
     *
     * @return $this
     */
    protected function images(array $value): self
    {
        $this->alias('image', Arr::first($value));

        return $this;
    }
}

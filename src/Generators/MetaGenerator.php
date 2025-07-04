<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\Generators;

use Gyrobus\MoonshineSeo\Concerns\HasConfig;
use Gyrobus\MoonshineSeo\Concerns\HasData;
use Gyrobus\MoonshineSeo\Concerns\HasDefaults;
use Gyrobus\MoonshineSeo\Contracts\GeneratesMetadata;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

use function array_merge;
use function view;

final class MetaGenerator implements GeneratesMetadata
{
    use HasConfig, HasData, HasDefaults;

    /**
     * @var array<string>
     */
    private array $custom = [];

    public function getName(): string
    {
        return 'meta';
    }

    /**
     * @return $this
     */
    public function title(?string $value, string|false|null $template = null): self
    {
        if ($template !== null) {
            $this->titleTemplate($template === false ? '' : $template);
        }

        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function titleTemplate(?string $value): self
    {
        if ($value === '') {
            $value = '{title}';
        }

        if (!Str::contains($value, '{title}')) {
            $value = '{title} - '.$value;
        }

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
     * @param array<string|null> $value
     *
     * @return $this
     */
    public function keywords(array $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function canonical(?string $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @return $this
     */
    public function canonicalEnabled(bool $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @param array<string|null> $value
     *
     * @return $this
     */
    public function robots(array $value): self
    {
        return $this->data(__FUNCTION__, $value);
    }

    /**
     * @param string|array<string> $content
     *
     * @return $this
     */
    public function tag(string $property, string|array $content): self
    {
        $this->custom[] = [$property => $content];

        return $this;
    }

    public function generate(): View
    {
        return view('moonshine-seo::meta', [
            'custom' => array_merge($this->config['custom'] ?? [], $this->custom),
        ] + $this->getData());
    }
}

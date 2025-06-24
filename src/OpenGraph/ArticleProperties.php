<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\OpenGraph;

use DateTime;
use Gyrobus\MoonshineSeo\OpenGraph\Contracts\Taggable;
use Gyrobus\MoonshineSeo\OpenGraph\Contracts\Type;

class ArticleProperties implements Taggable, Type
{
    /**
     * @param ProfileProperties|array<ProfileProperties>|null $author
     * @param string|array<string>|null $tag
     */
    public function __construct(
        public readonly ?DateTime $publishedTime = null,
        public readonly ?DateTime $modifiedTime = null,
        public readonly ?DateTime $expirationTime = null,
        public readonly ProfileProperties|array|null $author = null,
        public readonly ?string $section = null,
        public string|array|null $tag = null,
    ) {}

    public function getPrefix(): string
    {
        return 'article: https://ogp.me/ns/article#';
    }

    public function getType(): string
    {
        return 'article';
    }

    public function defaultTag(string|array $tag): void
    {
        if ($this->tag === null) {
            $this->tag = $tag;
        }
    }
}

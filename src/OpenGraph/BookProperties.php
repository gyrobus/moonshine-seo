<?php

declare(strict_types=1);

namespace Gyrobus\MoonshineSeo\OpenGraph;

use DateTime;
use Gyrobus\MoonshineSeo\OpenGraph\Contracts\Taggable;
use Gyrobus\MoonshineSeo\OpenGraph\Contracts\Type;

class BookProperties implements Taggable, Type
{
    /**
     * @param ProfileProperties|array<ProfileProperties>|null $author
     * @param string|array<string>|null $tag
     */
    public function __construct(
        public readonly ProfileProperties|array|null $author = null,
        public readonly ?string $isbn = null,
        public readonly ?DateTime $releaseDate = null,
        public string|array|null $tag = null,
    ) {}

    public function getPrefix(): string
    {
        return 'book: https://ogp.me/ns/book#';
    }

    public function getType(): string
    {
        return 'book';
    }

    public function defaultTag(string|array $tag): void
    {
        if ($this->tag === null) {
            $this->tag = $tag;
        }
    }
}

<?php

namespace App\Domain\Models;

use App\Domain\ValueObject\Enums\BlogPostSource;

class BlogPostModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly BlogPostSource $source,
        public readonly bool $isPublished,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSource(): BlogPostSource
    {
        return $this->source;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}

<?php

namespace App\DTO;

use App\Enums\BlogPostSource;
use App\Http\Requests\Api\BlogPostRequest;

class BlogPostDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly BlogPostSource $blogPostSource,
        public readonly bool $isPublished,
    ) {

    }

    public static function fromRequest(BlogPostRequest $request): BlogPostDto
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            blogPostSource: BlogPostSource::Api,
            isPublished: $request->validated('is-published'),
        );
    }
}

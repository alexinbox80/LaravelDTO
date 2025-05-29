<?php

namespace App\Infrastructure\Repositories\Elasticsearch;

use App\Domain\Models\BlogPostModel;

class BlogPostDecorator
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository
    )
    {
    }

    /**
     * @param string $query
     * @return BlogPostModel[]
     */
    public function search(string $query): array
    {
        $blogPosts = $this->blogPostRepository->search($query)->where(['isPublished' => true])->get();

        $result = [];
        foreach ($blogPosts as $blogPost) {
            $result[] = new BlogPostModel(
                $blogPost->id,
                $blogPost->title,
                $blogPost->description,
                $blogPost->source,
                $blogPost->isPublished,
                $blogPost->created_at,
                $blogPost->updated_at
            );
        }

        return $result;
    }
}

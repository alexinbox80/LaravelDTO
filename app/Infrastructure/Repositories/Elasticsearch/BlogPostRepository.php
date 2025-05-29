<?php

namespace App\Infrastructure\Repositories\Elasticsearch;

use App\Domain\Entity\BlogPost;

class BlogPostRepository extends ElasticsearchRepository
{
    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return BlogPost::class;
    }
}

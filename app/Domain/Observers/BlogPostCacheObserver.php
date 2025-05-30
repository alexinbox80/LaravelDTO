<?php

namespace App\Domain\Observers;

use App\Domain\Entity\BlogPost;
use App\Domain\Repository\Redis\RedisRepositoryContract;
use App\Domain\ValueObject\Enums\CacheTags;
use Illuminate\Support\Facades\Log;

class BlogPostCacheObserver
{
    public function __construct(
        private readonly RedisRepositoryContract $redis
    )
    {
    }

    /**
     * Обработать событие «created» модели.
     */
    public function created(BlogPost $blogPost): void
    {
        Log::info('BlogPost created', ['blogPost' => $blogPost]);
        $this->redis->cacheFlush(CacheTags::BlogPosts->value);
    }

    /**
     * Обработать событие «updated» модели.
     */
    public function updated(BlogPost $blogPost): void
    {
        Log::info('BlogPost updated', ['blogPost' => $blogPost]);
        $this->redis->cacheFlush(CacheTags::BlogPosts->value);
    }

    /**
     * Обработать событие «deleted» модели.
     */
    public function deleted(BlogPost $blogPost): void
    {
        Log::info('BlogPost deleted', ['blogPost' => $blogPost]);
        $this->redis->cacheFlush(CacheTags::BlogPosts->value);
    }
}

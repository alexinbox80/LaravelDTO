<?php

namespace App\Domain\Repository\Redis;

/**
 * Interface EloquentRepositoryContract.
 */
interface RedisRepositoryContract
{
    public function getCacheKey(string $tag, int $page, int $perPage): string;

    public function cacheFlush(string $tag): void;
}

<?php

namespace App\Infrastructure\Repositories\Redis\Contracts;

/**
 * Interface EloquentRepositoryContract.
 */
interface RedisRepositoryContract
{
    public function getCacheKey(string $tag, int $page, int $perPage): string;
}

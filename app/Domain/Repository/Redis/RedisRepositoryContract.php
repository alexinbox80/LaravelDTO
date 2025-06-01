<?php

namespace App\Domain\Repository\Redis;

/**
 * Interface EloquentRepositoryContract.
 */
interface RedisRepositoryContract
{
    public function getCachePaginated(int $page, int $perPage, string $tag, array $items): array;

    public function cacheFlush(string $tag): void;
}

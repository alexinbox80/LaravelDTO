<?php

namespace App\Infrastructure\Repositories\Redis;


use App\Domain\Repository\Redis\RedisRepositoryContract;
use Illuminate\Support\Facades\Cache;

class RedisRepository implements RedisRepositoryContract
{
    public function getCacheKey(string $tag, int $page, int $perPage): string
    {
        return $tag . "_{$page}_$perPage";
    }

    public function cacheFlush(string $tag): void
    {
        Cache::tags([$tag])->flush();
    }
}

<?php

namespace App\Infrastructure\Repositories\Redis;

use App\Infrastructure\Repositories\Redis\Contracts\RedisRepositoryContract;

class RedisRepository implements RedisRepositoryContract
{
    public function getCacheKey(string $tag, int $page, int $perPage): string
    {
        return $tag . "_{$page}_$perPage";
    }
}

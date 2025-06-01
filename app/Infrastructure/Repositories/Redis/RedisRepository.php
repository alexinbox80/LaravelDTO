<?php

namespace App\Infrastructure\Repositories\Redis;


use App\Domain\Repository\Redis\RedisRepositoryContract;
use Illuminate\Support\Facades\Cache;

class RedisRepository implements RedisRepositoryContract
{
    private function getCacheKey(string $tag, int $page, int $perPage): string
    {
        return $tag . "_{$page}_$perPage";
    }

    public function getCachePaginated(int $page, int $perPage, string $tag, array $items): array
    {
        return Cache::get(
            $this->getCacheKey($tag, $page, $perPage),
            function () use ($page, $perPage, $tag, $items) {
                Cache::tags([$tag])->put($this->getCacheKey($tag, $page, $perPage), $items);
                return $items;
            }
        );
    }

    public function cacheFlush(string $tag): void
    {
        Cache::tags([$tag])->flush();
    }
}

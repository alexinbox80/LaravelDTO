<?php

namespace App\Domain\Services\Cache;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Support\Facades\Log;

class CacheMonitoringService
{
    public function subscribe(object $events): void
    {
        $events->listen(CacheHit::class, function (object $event) {
            $this->recordMetric('hits', [
                'key' => $event->key,
                'tags' => $event->tags,
                'response_time' => microtime(true) - LARAVEL_START
            ]);
        });

        $events->listen(CacheMissed::class, function (object $event) {
            $this->recordMetric('misses', [
                'key' => $event->key,
                'tags' => $event->tags
            ]);
        });

        $events->listen(KeyWritten::class, function (object $event) {
            $this->recordMetric('writes', [
                'key' => $event->key,
                'tags' => $event->tags,
                'ttl' => $event->seconds ?? 'forever'
            ]);
        });
    }

    private function recordMetric(string $type, array $data): void
    {
        Log::info(json_encode(['type' => $type, 'data' => $data]));
        // Store metrics in your monitoring system
        // Example: StatsD, Prometheus, etc.
    }
}

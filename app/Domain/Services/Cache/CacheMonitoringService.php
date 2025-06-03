<?php

namespace App\Domain\Services\Cache;

use App\Domain\Repository\Metrics\Contracts\MetricsContract;
use App\Domain\ValueObject\Enums\Metric;
use App\Infrastructure\Repositories\Metrics\MetricsRepository;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Support\Facades\App;
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
        $metricsRepository = App::make(MetricsContract::class);

        Log::info(json_encode(['type' => $type, 'data' => $data]));

        switch ($type) {
            case 'hits':
                $metricsRepository->writeNumericValue(Metric::CACHE_HIT, 1, $data['tags'], $data['response_time']);
            break;

            case 'misses':

            break;
        }

        // Store metrics in your monitoring system
        // Example: StatsD, Prometheus, etc.
    }
}

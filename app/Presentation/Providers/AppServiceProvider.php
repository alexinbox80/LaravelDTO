<?php

namespace App\Presentation\Providers;

use App\Domain\Entity\BlogPost;
use App\Domain\Observers\BlogPostCacheObserver;
use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use App\Domain\Repository\Redis\RedisRepositoryContract;
use App\Domain\Services\Contracts\ResponseContract;
use App\Domain\Services\Response\ResponseService;
use App\Infrastructure\Repositories\Eloquent\BlogPostDecorator;
use App\Infrastructure\Repositories\Redis\RedisRepository;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerSearchClient();

        $this->app->bind(ResponseContract::class, ResponseService::class);
        $this->app->bind(RedisRepositoryContract::class, RedisRepository::class);
        $this->app->bind(BlogPostContract::class, BlogPostDecorator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BlogPost::observe(BlogPostCacheObserver::class);
        $this->bootSearchable();
    }

    private function registerSearchClient(): void
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    private function bootSearchable(): void
    {
        BlogPost::bootSearchable();
    }
}

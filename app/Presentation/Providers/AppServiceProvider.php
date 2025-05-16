<?php

namespace App\Presentation\Providers;

use App\Domain\Repository\Eloquent\Contracts\BlogPostContract;
use App\Domain\Services\Contracts\ResponseContract;
use App\Domain\Services\Response\ResponseService;
use App\Infrastructure\Repositories\Eloquent\BlogPostDecorator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseContract::class, ResponseService::class);
        $this->app->bind(BlogPostContract::class, BlogPostDecorator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

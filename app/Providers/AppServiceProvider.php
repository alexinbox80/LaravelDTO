<?php

namespace App\Providers;

use App\Repositories\Eloquent\BlogPostDecorator;
use App\Repositories\Eloquent\Contracts\BlogPostContract;
use App\Services\Contracts\ResponseContract;
use App\Services\Response\ResponseService;
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

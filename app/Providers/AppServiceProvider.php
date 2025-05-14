<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

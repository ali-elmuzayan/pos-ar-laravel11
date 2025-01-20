<?php

namespace App\Providers;

use App\Services\OrderService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // constants that I need
    public const PAGINATION_LIMIT = 10;



    /**
     * Register any application services.
     */
    public function register(): void
    {
        // to bind the service
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrap();
    }
}

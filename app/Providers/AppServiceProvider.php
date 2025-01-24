<?php

namespace App\Providers;

use App\Services\SeoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        require_once __DIR__ . '/../helpers.php';

        // seo服务使用单例模式
        $this->app->singleton(SeoService::class, function () {
            return new SeoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

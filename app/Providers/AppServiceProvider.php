<?php

namespace App\Providers;

use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\LogRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\LogExportService;
use App\Services\LogService;
use App\Services\LogStatsService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LogRepositoryInterface::class,
            LogRepository::class
        );

        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(LogExportService::class, function ($app) {
            return new LogExportService(
                $app->make(LogRepositoryInterface::class)
            );
        });

        $this->app->bind(LogStatsService::class, function ($app) {
            return new LogStatsService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}

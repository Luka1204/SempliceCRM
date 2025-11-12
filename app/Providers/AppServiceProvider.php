<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\ContactRepository;
use App\Repositories\DealRepository;
use App\Repositories\ActivityRepository;

use App\Services\CompanyService;
use App\Services\ContactService;
use App\Services\ActivityService;

use App\Services\DashboardService;
use App\Services\DealService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(CompanyRepository::class, function ($app) {
            return new CompanyRepository();
        });

        $this->app->bind(ContactRepository::class, function ($app) {
            return new ContactRepository();
        });

        // Services
        $this->app->bind(CompanyService::class, function ($app) {
            return new CompanyService(
                $app->make(CompanyRepository::class)
            );
        });

        $this->app->bind(ContactService::class, function ($app) {
            return new ContactService(
                $app->make(ContactRepository::class)
            );
        });
        $this->app->bind(DashboardService::class, function ($app) {
            return new DashboardService();
        });
        $this->app->bind(DealRepository::class, function ($app) {
            return new DealRepository();
        });

        $this->app->bind(DealService::class, function ($app) {
            return new DealService(
                $app->make(DealRepository::class)
            );
        });

         $this->app->bind(ActivityRepository::class, function ($app) {
            return new ActivityRepository();
        });

        $this->app->bind(ActivityService::class, function ($app) {
            return new ActivityService(
                $app->make(ActivityRepository::class)
            );
        });
        
    }

    public function boot(): void
    {
        //
    }
}
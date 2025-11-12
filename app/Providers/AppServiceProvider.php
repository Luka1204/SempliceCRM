<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\ContactRepository;

use App\Services\CompanyService;
use App\Services\ContactService;

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
}

    public function boot(): void
    {
        //
    }
}
<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Deal;
use App\Models\Contact;
use App\Models\Activity;

use App\Policies\CompanyPolicy;
use App\Policies\ContactPolicy;
use App\Policies\DealPolicy;
use App\Policies\ActivityPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Contact::class => ContactPolicy::class,
        Deal::class => DealPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
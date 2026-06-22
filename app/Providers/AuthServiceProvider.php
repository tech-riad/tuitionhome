<?php

namespace App\Providers;

use App\Models\Institute;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
         $this->registerPolicies();

        Passport::tokensCan([
            'parents' => 'parents user Type',
            'tutors' => 'tutors user Type',
            'affiliates' => 'tutors user Type',
            'inactive_tutors' => 'inactive tutors user Type',
        ]);

        Passport::routes();

    }
}

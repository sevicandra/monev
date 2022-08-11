<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        Gate::define('sys_admin', function (User $user) {
            return $user->is('01') === true;
        });

        Gate::define('admin_satker', function (User $user) {
            return $user->is('02') === true;
        });

        Gate::define('KPA', function (User $user) {
            return $user->is('03') === true;
        });

        Gate::define('Staf_KPA', function (User $user) {
            return $user->is('04') === true;
        });

        Gate::define('PPK', function (User $user) {
            return $user->is('05') === true;
        });

        Gate::define('Staf_PPK', function (User $user) {
            return $user->is('06') === true;
        });

        Gate::define('PPSPM', function (User $user) {
            return $user->is('07') === true;
        });

        Gate::define('Bendahara', function (User $user) {
            return $user->is('08') === true;
        });

        Gate::define('Validator', function (User $user) {
            return $user->is('09') === true;
        });
    }
}

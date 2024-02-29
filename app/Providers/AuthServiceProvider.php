<?php

namespace App\Providers;

use App\Models\unit;
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

        Gate::define('sys_admin', function () {
            // return $user->is('01') === true;
            return in_array('01', session()->get('role'));
        });

        Gate::define('admin_satker', function () {
            // return $user->is('02') === true;
            return in_array('02', session()->get('role'));

        });

        Gate::define('KPA', function () {
            // return $user->is('03') === true;
            return in_array('03', session()->get('role'));
        });

        Gate::define('Staf_KPA', function () {
            // return $user->is('04') === true;
            return in_array('04', session()->get('role'));
        });

        Gate::define('PPK', function () {
            // return $user->isPpk() === true;
            return in_array('05', session()->get('role'));
        });

        Gate::define('Staf_PPK', function () {
            // return $user->isStafPpk() === true;
            return in_array('06', session()->get('role'));
        });

        Gate::define('PPSPM', function () {
            // return $user->is('07') === true;
            return in_array('07', session()->get('role'));
        });

        Gate::define('Bendahara', function () {
            // return $user->is('08') === true;
            return in_array('08', session()->get('role'));
        });

        Gate::define('Validator', function () {
            // return $user->is('09') === true;
            return in_array('09', session()->get('role'));
        });

        Gate::define('ValidatorKKP', function () {
            // return $user->is('09') === true;
            return in_array('10', session()->get('role'));
        });

        Gate::define('tahun', function ($key) {
            return $key === session()->get('tahun');
        });

        Gate::define('satker', function ($key) {
            return auth()->user()->satker === $key;
        });

        Gate::define('verifikaor_unit', function(User $user, unit $unit){
            return $user->verifikatorunit($unit->id) === true;
        });
    }
}

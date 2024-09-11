<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('only-admin', function ($user) {
            return $user->role_id === 1; // Hanya role ID 1 yang memiliki akses
        });

        Gate::define('super-power', function ($user) {
            // return $user->role_id === 1; // Hanya role ID 1 yang memiliki akses
            return $user->email == '198801072018015001';
        });
    }
}
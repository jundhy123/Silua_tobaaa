<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // =========================================================
        // PEMBATAS AKSES (GATES) - SILUA TOBA
        // =========================================================

        // Pembatas untuk Admin (Hanya bisa diakses jika role = admin)
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Pembatas untuk Customer (Hanya bisa diakses jika role = pelanggan)
        Gate::define('access-customer', function (User $user) {
            return $user->role === 'pelanggan';
        });
    }
}
<?php

namespace App\Providers;

use App\Models\User;
use App\Models\CompanyProfile; // 1. Pastikan Model CompanyProfile di-import
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View; // 2. Pastikan Facade View di-import
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
        // 1. PEMBAGIAN DATA GLOBAL (VIEW COMPOSER)
        // =========================================================
        
        // Mengirimkan data profil ke halaman user (satu record untuk logo/info)
        View::composer('user.*', function ($view) {
            $view->with('profile', CompanyProfile::first());
        });


        // =========================================================
        // 2. PEMBATAS AKSES (GATES) - SILUA TOBA
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
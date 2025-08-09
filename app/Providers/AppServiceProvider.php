<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL; // Tambahkan ini untuk menggunakan facade URL
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\User;           // Import model User
use App\Observers\UserObserver; // Import observer UserObserver

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
        // Pakai Bootstrap untuk pagination
        Paginator::useBootstrap();

        // Daftarkan UserObserver untuk model User
        User::observe(UserObserver::class); // BARIS INI DITAMBAHKAN

        // Paksa HTTPS di environment non-local
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}

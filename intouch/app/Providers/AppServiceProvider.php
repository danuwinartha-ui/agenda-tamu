<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Paksa semua link (CSS/JS) menggunakan HTTPS jika di Cloudflare
        if (str_contains(config('app.url'), 'trycloudflare.com')) {
            URL::forceScheme('https');
        }
    }
}

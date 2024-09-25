<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Jangan tambahkan binding kustom di sini kecuali diperlukan.
    }

    public function boot(): void
    {
        // Kosongkan jika tidak ada logika khusus yang diperlukan.
    }
}

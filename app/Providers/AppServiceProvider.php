<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // ← AJOUTE CETTE LIGNE

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Rien ici — on met boot(), pas register()
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191); // ✅ OK maintenant
    }
}
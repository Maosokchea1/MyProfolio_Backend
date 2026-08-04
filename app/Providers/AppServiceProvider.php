<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- បន្ថែម namespace នេះ

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
        // បង្ខំរាល់ URL ទាំងអស់ឱ្យប្រើប្រាស់ HTTPS ជៀសវាងបញ្ហា Form not secure នៅលើ Render
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
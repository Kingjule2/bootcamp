<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Blade::component('components.Shared.button', 'components.shared.button');
        \Illuminate\Support\Facades\Blade::component('components.Shared.input', 'components.shared.input');
        \Illuminate\Support\Facades\Blade::component('components.Shared.modal', 'components.shared.modal');
    }
}

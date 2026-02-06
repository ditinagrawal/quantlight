<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        View::composer('layouts.quantlight', function ($view) {
            $view->with('quantlightHeaderHtml', quantlight_fragment('header'));
            $view->with('quantlightFooterHtml', quantlight_fragment('footer'));
        });
    }
}

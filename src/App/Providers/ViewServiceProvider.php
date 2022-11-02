<?php

namespace App\Providers;

use App\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'includes.frontend.header',
                'includes.backend.header',
                'home', 'includes.frontend.footer',
                'frontend.partials.mobile-menu',
                'frontend.news',
                'frontend.gallery',
                'frontend.page',

            ],
            HeaderComposer::class
        );
    }
}

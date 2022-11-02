<?php

namespace App\Providers;

use App\Faker\ColorProvider;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $faker = $this->app->make(Generator::class);
        $faker->addProvider(new ColorProvider($faker));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

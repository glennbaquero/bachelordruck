<?php

namespace Support\Translator\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Support\Translator\Interfaces\TranslatorInterface;

class TranslatorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TranslatorInterface::class, function ($app) {
            /** @var TranslatorInterface $translator */
            $translator = app(config('translator.service_class'));
            $translator->setApiKey(config('translator.api_key'));

            return $translator;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

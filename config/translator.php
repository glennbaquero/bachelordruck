<?php

return [
    'api_key' => env('TRANSLATOR_API_KEY'),

    'service_class' => \Support\Translator\Services\DeeplTranslatorService::class,
];

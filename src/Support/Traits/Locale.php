<?php

namespace Support\Traits;

trait Locale
{
    public function getLocale()
    {
        return match (config('app.locale')) {
            'de' => 'de_DE',
            default => 'en_US'
        };
    }
}

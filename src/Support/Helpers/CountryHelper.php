<?php

namespace Support\Helpers;

use Nnjeim\World\World;

class CountryHelper
{
    public static function get(string $lang = null)
    {
        $response = World::setLocale($lang ?? 'en')->countries([
            'fields' => 'iso2',
        ]);

        $countries = $response->data;

        return $countries->map(function ($country) {
            return [
                'id' => $country['iso2'],
                'label' => $country['name'],
            ];
        })->toArray();
    }
}

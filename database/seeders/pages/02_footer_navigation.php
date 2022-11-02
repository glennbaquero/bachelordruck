<?php

use Domain\Pages\Models\Language;
use Domain\Pages\Models\Layout;

$languages = cache()->remember('languages', now()->addMinute(), fn () => Language::all());
$layouts = cache()->remember('layouts', now()->addMinute(), fn () => Layout::all());

$deId = $languages->where('languageCode', 'de')->first()->id;
$enId = $languages->where('languageCode', 'en')->first()->id;
$homeId = $layouts->where('token', 'bachelordruck.home')->first()->id;

return [
    'name' => 'Footer Navigation',
    'url' => '',
    'language_id' => $deId,
    'active' => false,
    'visible' => false,

    'children' => [
        // Impressum
        [
            '_id' => 'impressum',
            'name' => 'Impressum',
            'url' => '/impressum',
            'language_id' => $deId,
            'layout_id' => $homeId,
        ],
        // Datenschutzerklärung
        [
            '_id' => 'datenschutzerklarung',
            'name' => 'Datenschutzerklärung',
            'url' => '/datenschutzerklarung',
            'language_id' => $deId,
            'layout_id' => $homeId,
        ],
        // Zahlungsarten
        [
            '_id' => 'zahlungsarten',
            'name' => 'Zahlungsarten',
            'url' => '/zahlungsarten',
            'language_id' => $deId,
            'layout_id' => $homeId,
        ],
        // Widerrufsbelehrung
        [
            '_id' => 'widerrufsbelehrung',
            'name' => 'Widerrufsbelehrung',
            'url' => '/widerrufsbelehrung',
            'language_id' => $deId,
            'layout_id' => $homeId,
        ],
        // AGB
        [
            '_id' => 'agb',
            'name' => 'AGB',
            'url' => '/agb',
            'language_id' => $deId,
            'layout_id' => $homeId,
        ],
    ],
];

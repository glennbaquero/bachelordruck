<?php

return [
    'search' => [
        'url' => 'https://services.mobile.de/search-api/search',
        'default_params' => [
            'classification' => 'refdata/classes/Car',
        ],
        'ad_url' => 'https://services.mobile.de/search-api/ad',
    ],

    'specifications_url' => [
        'airbag' => 'https://services.mobile.de/refdata/airbags',
        'category' => 'https://services.mobile.de/refdata/classes/{class}/categories',
        'classification' => 'https://services.mobile.de/refdata/classes',
        'color' => 'https://services.mobile.de/refdata/colors',
        'daytime_running_lamp' => 'https://services.mobile.de/refdata/daytimerunninglamps',
        'door' => 'https://services.mobile.de/refdata/doorcounts',
        'feature' => 'https://services.mobile.de/refdata/classes/Car/features',
        'fuel_type' => 'https://services.mobile.de/refdata/fuels',
        'gearbox' => 'https://services.mobile.de/refdata/gearboxes',
        'interior_type' => 'https://services.mobile.de/refdata/interiorTypes',
        'make' => 'https://services.mobile.de/refdata/classes/Car/makes',
        'model' => 'https://services.mobile.de/refdata/classes/Car/makes/{make}/models',
        'parking_assistant' => 'https://services.mobile.de/refdata/parkingassistants',
        'radio_type' => 'https://services.mobile.de/refdata/radiotypes',
        'speed_control' => 'https://services.mobile.de/refdata/speedcontrols',
        'usage_type' => 'https://services.mobile.de/refdata/usagetypes',
    ],

    'root_storage_folder' => 'vehicles',

    'credentials' => [
        'username' => env('VEHICLES_USERNAME'),
        'password' => env('VEHICLES_PASSWORD'),
    ],

    // Minutes to run commands as cronjob
    'latest_minutes' => env('VEHICLES_LATEST_MINUTES', 15),
    'sync_minutes' => env('VEHICLES_SYNC_MINUTES', 17),

    // The max amount that can be financed
    'max_financing_amount' => env('VEHICLES_MAX_FINANCING_AMOUNT', 99_999.00),
];

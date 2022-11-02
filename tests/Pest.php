<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Models\Container;
use Domain\Pages\Models\PageLanguage;
use Domain\Vehicles\Enums\SpecificationTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createContainerData(PageLanguage $pageLanguage)
{
    Container::factory()->create([
        'sort' => 1,
        'pages_language_id' => $pageLanguage->id,
        'type' => ContainerTypeEnum::HEADLINE_TEXT_IMAGE->value,
    ]);

    Container::factory()->create([
        'sort' => 2,
        'pages_language_id' => $pageLanguage->id,
    ]);

    Container::factory()->create([
        'sort' => 3,
        'pages_language_id' => $pageLanguage->id,
    ]);
}

function attachMediaToModel(Model $model, string $collection = 'images', string $disk = 'images')
{
    Storage::fake($disk);

    config()->set('filesystems.disks.'.$disk, [
        'driver' => 'local',
        'root' => Storage::disk($disk)->getConfig(),
    ]);

    $model
        ->addMedia(base_path('tests/stubs/space.png'))
        ->preservingOriginal()
        ->toMediaCollection($collection, $disk);
}

function setVehiclesConfig()
{
    config()->set('vehicles.search', [
        'url' => 'https://services.mobile.de/search-api/search',
        'default_params' => [
            'classification' => 'refdata/classes/Car',
        ],
        'ad_url' => 'https://services.mobile.de/search-api/ad',
    ]);

    config()->set('vehicles.specifications_url', [
        'airbag' => 'https://services.mobile.de/refdata/airbags',
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
    ]);

    config()->set('vehicles.root_storage_folder', 'vehicles');
    config()->set('vehicles.credentials', [
        'username' => '',
        'password' => '',
    ]);
}

/**
 * @throws JsonException
 */
function getJsonAsArray(string $filename): array
{
    return json_decode(file_get_contents(base_path("tests/Datasets/jsons/{$filename}")), true, 512, JSON_THROW_ON_ERROR);
}

function getSpecification(Collection $specifications, SpecificationTypeEnum $specificationType)
{
    return $specifications->where('type', $specificationType)->first();
}

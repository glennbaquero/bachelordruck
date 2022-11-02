<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\AdditionalServiceCreateAction;
use Domain\Products\Actions\AdditionalServiceDeleteAction;
use Domain\Products\Actions\AdditionalServiceUpdateAction;
use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\FieldEnums\AdditionalServiceFieldEnum;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Rules\AdditionalServiceRules;

test('create additionalService data from model', function () {
    /** @var AdditionalService $additionalService */
    $additionalService = AdditionalService::factory()->make();

    $data = AdditionalServiceData::fromModel($additionalService);

    expect($data)
        ->title->toEqual($additionalService->title)
        ->tooltip->toEqual($additionalService->tooltip)
        ->surcharge->toEqual($additionalService->surcharge)
        ->sort->toEqual($additionalService->sort)
        ->status->toEqual($additionalService->status);
});

test('additionalService create action', function () {
    /** @var AdditionalService $additionalService */
    $additionalService = AdditionalService::factory()->make();

    $data = AdditionalServiceData::fromModel($additionalService);

    app(AdditionalServiceCreateAction::class)($data);

    $dataArray = $data->toArray();

    $dataArray['surcharge'] *= 100;

    $this->assertDatabaseHas('additional_services', $dataArray);
});

test('additionalService update action', function () {
    $additionalService = AdditionalService::factory()->create();

    $data = AdditionalServiceData::fromModel($additionalService);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(AdditionalServiceUpdateAction::class)($additionalService, $data);

    $additionalService->refresh();

    expect($additionalService)
        ->title->toEqual($newFieldValue);
});

test('additionalService delete action', function () {
    $additionalService = AdditionalService::factory()->create();

    app(AdditionalServiceDeleteAction::class)($additionalService);

    $this->assertModelMissing($additionalService);
});

test('additionalService field enum labels', function () {
    app()->setLocale('en');

    expect(AdditionalServiceFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'tooltip' => 'Tooltip',
        'surcharge' => 'Surcharge',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('additionalService rules key is prepended', function () {
    expect(array_keys(AdditionalServiceRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('additionalService.');
});

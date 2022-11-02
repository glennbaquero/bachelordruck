<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductCoverFoilCreateAction;
use Domain\Products\Actions\ProductCoverFoilDeleteAction;
use Domain\Products\Actions\ProductCoverFoilUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\FieldEnums\ProductCoverFoilFieldEnum;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Rules\ProductCoverFoilRules;

test('create productCoverFoil data from model', function () {
    $productCoverFoil = ProductCoverFoil::factory()->make();

    $data = ProductCoverFoilData::fromModel($productCoverFoil);

    expect($data)
        ->title->toEqual($productCoverFoil->title)
        ->is_preselected->toEqual($productCoverFoil->is_preselected)
        ->sort->toEqual($productCoverFoil->sort)
        ->status->toEqual($productCoverFoil->status);
});

test('productCoverFoil create action', function () {
    /** @var ProductCoverFoil $productCoverFoil */
    $productCoverFoil = ProductCoverFoil::factory()->make();

    $data = ProductCoverFoilData::fromModel($productCoverFoil);

    app(ProductCoverFoilCreateAction::class)($data);

    $this->assertDatabaseHas('product_cover_foils', $data->toArray());
});

test('productCoverFoil update action', function () {
    $productCoverFoil = ProductCoverFoil::factory()->create();

    $data = ProductCoverFoilData::fromModel($productCoverFoil);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductCoverFoilUpdateAction::class)($productCoverFoil, $data);

    $productCoverFoil->refresh();

    expect($productCoverFoil)
        ->title->toEqual($newFieldValue);
});

test('productCoverFoil delete action', function () {
    $productCoverFoil = ProductCoverFoil::factory()->create();

    app(ProductCoverFoilDeleteAction::class)($productCoverFoil);

    $this->assertModelMissing($productCoverFoil);
});

test('productCoverFoil field enum labels', function () {
    app()->setLocale('en');

    expect(ProductCoverFoilFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
        'image' => 'Image',
    ]);
});

test('productCoverFoil rules key is prepended', function () {
    expect(array_keys(ProductCoverFoilRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productCoverFoil.');
});

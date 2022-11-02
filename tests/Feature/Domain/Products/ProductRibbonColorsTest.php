<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductRibbonColorCreateAction;
use Domain\Products\Actions\ProductRibbonColorDeleteAction;
use Domain\Products\Actions\ProductRibbonColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\FieldEnums\ProductRibbonColorFieldEnum;
use Domain\Products\Models\ProductRibbonColor;
use Domain\Products\Rules\ProductRibbonColorRules;

test('create productRibbonColor data from model', function () {
    $productRibbonColor = ProductRibbonColor::factory()->make();

    $data = ProductRibbonColorData::fromModel($productRibbonColor);

    expect($data)
        ->title->toEqual($productRibbonColor->title)
        ->color->toEqual($productRibbonColor->color)
        ->is_preselected->toEqual($productRibbonColor->is_preselected)
        ->sort->toEqual($productRibbonColor->sort)
        ->status->toEqual($productRibbonColor->status);
});

test('productRibbonColor create action', function () {
    /** @var ProductRibbonColor $productRibbonColor */
    $productRibbonColor = ProductRibbonColor::factory()->make();

    $data = ProductRibbonColorData::fromModel($productRibbonColor);

    app(ProductRibbonColorCreateAction::class)($data);

    $this->assertDatabaseHas('product_ribbon_colors', $data->toArray());
});

test('productRibbonColor update action', function () {
    $productRibbonColor = ProductRibbonColor::factory()->create();

    $data = ProductRibbonColorData::fromModel($productRibbonColor);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductRibbonColorUpdateAction::class)($productRibbonColor, $data);

    $productRibbonColor->refresh();

    expect($productRibbonColor)
        ->title->toEqual($newFieldValue);
});

test('productRibbonColor delete action', function () {
    $productRibbonColor = ProductRibbonColor::factory()->create();

    app(ProductRibbonColorDeleteAction::class)($productRibbonColor);

    $this->assertModelMissing($productRibbonColor);
});

test('productRibbonColor field enum labels', function () {
    app()->setLocale('en');

    expect(ProductRibbonColorFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'color' => 'Color',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productRibbonColor rules key is prepended', function () {
    expect(array_keys(ProductRibbonColorRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productRibbonColor.');
});

<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductCoverImprintColorCreateAction;
use Domain\Products\Actions\ProductCoverImprintColorDeleteAction;
use Domain\Products\Actions\ProductCoverImprintColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\FieldEnums\ProductCoverImprintColorFieldEnum;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Rules\ProductCoverImprintColorRules;

test('create productCoverImprintColor data from model', function () {
    /** @var ProductCoverImprintColor $productCoverImprintColor */
    $productCoverImprintColor = ProductCoverImprintColor::factory()->make();

    $data = ProductCoverImprintColorData::fromModel($productCoverImprintColor);

    expect($data)
        ->title->toEqual($productCoverImprintColor->title)
        ->color->toEqual($productCoverImprintColor->color)
        ->is_preselected->toEqual($productCoverImprintColor->is_preselected)
        ->sort->toEqual($productCoverImprintColor->sort)
        ->status->toEqual($productCoverImprintColor->status);
});

test('productCoverImprintColor create action', function () {
    /** @var ProductCoverImprintColor $productCoverImprintColor */
    $productCoverImprintColor = ProductCoverImprintColor::factory()->make();

    $data = ProductCoverImprintColorData::fromModel($productCoverImprintColor);

    app(ProductCoverImprintColorCreateAction::class)($data);

    $this->assertDatabaseHas('product_cover_imprint_colors', $data->toArray());
});

test('productCoverImprintColor update action', function () {
    $productCoverImprintColor = ProductCoverImprintColor::factory()->create();

    $data = ProductCoverImprintColorData::fromModel($productCoverImprintColor);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductCoverImprintColorUpdateAction::class)($productCoverImprintColor, $data);

    $productCoverImprintColor->refresh();

    expect($productCoverImprintColor)
        ->title->toEqual($newFieldValue);
});

test('productCoverImprintColor delete action', function () {
    $productCoverImprintColor = ProductCoverImprintColor::factory()->create();

    app(ProductCoverImprintColorDeleteAction::class)($productCoverImprintColor);

    $this->assertModelMissing($productCoverImprintColor);
});

test('productCoverImprintColor field enum labels', function () {
    app()->setLocale('en');

    expect(ProductCoverImprintColorFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'color' => 'Color',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productCoverImprintColor rules key is prepended', function () {
    expect(array_keys(ProductCoverImprintColorRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productCoverImprintColor.');
});

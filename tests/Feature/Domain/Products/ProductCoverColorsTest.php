<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductCoverColorCreateAction;
use Domain\Products\Actions\ProductCoverColorDeleteAction;
use Domain\Products\Actions\ProductCoverColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\FieldEnums\ProductCoverColorFieldEnum;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Rules\ProductCoverColorRules;

test('create productCoverColor data from model', function () {
    /** @var ProductCoverColor $productCoverColor */
    $productCoverColor = ProductCoverColor::factory()->make();

    $data = ProductCoverColorData::fromModel($productCoverColor);

    expect($data)
        ->product_id->toEqual($productCoverColor->product_id)
        ->title->toEqual($productCoverColor->title)
        ->is_preselected->toEqual($productCoverColor->is_preselected)
        ->sort->toEqual($productCoverColor->sort)
        ->status->toEqual($productCoverColor->status);
});

test('productCoverColor create action', function () {
    $productCoverColor = ProductCoverColor::factory()->make();

    $data = ProductCoverColorData::fromModel($productCoverColor);

    app(ProductCoverColorCreateAction::class)($data);

    $this->assertDatabaseHas('product_cover_colors', $data->toArray());
});

test('productCoverColor update action', function () {
    $productCoverColor = ProductCoverColor::factory()->create();

    $data = ProductCoverColorData::fromModel($productCoverColor);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductCoverColorUpdateAction::class)($productCoverColor, $data);

    $productCoverColor->refresh();

    expect($productCoverColor)
        ->title->toEqual($newFieldValue);
});

test('productCoverColor delete action', function () {
    $productCoverColor = ProductCoverColor::factory()->create();

    app(ProductCoverColorDeleteAction::class)($productCoverColor);

    $this->assertModelMissing($productCoverColor);
});

test('productCoverColor field enum labels', function () {
    app()->setLocale('en');

    expect(ProductCoverColorFieldEnum::labels())->toBe([
        'id' => 'Id',
        'product_id' => 'Product',
        'product.title' => 'Product Title',
        'title' => 'Title',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
        'image' => 'Image',
    ]);
});

test('productCoverColor rules key is prepended', function () {
    expect(array_keys(ProductCoverColorRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productCoverColor.');
});

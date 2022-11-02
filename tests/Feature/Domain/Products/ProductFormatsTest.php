<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductFormatCreateAction;
use Domain\Products\Actions\ProductFormatDeleteAction;
use Domain\Products\Actions\ProductFormatUpdateAction;
use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\FieldEnums\ProductFormatFieldEnum;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Rules\ProductFormatRules;

test('create productFormat data from model', function () {
    $productFormat = ProductFormat::factory()->make();

    $data = ProductFormatData::fromModel($productFormat);

    expect($data)
        ->product_id->toEqual($productFormat->product_id)
        ->title->toEqual($productFormat->title)
        ->is_preselected->toEqual($productFormat->is_preselected)
        ->sort->toEqual($productFormat->sort)
        ->status->toEqual($productFormat->status);
});

test('productFormat create action', function () {
    /** @var ProductFormat $productFormat */
    $productFormat = ProductFormat::factory()->make();

    $data = ProductFormatData::fromModel($productFormat);

    app(ProductFormatCreateAction::class)($data);

    $this->assertDatabaseHas('product_formats', $data->toArray());
});

test('productFormat update action', function () {
    $productFormat = ProductFormat::factory()->create();

    $data = ProductFormatData::fromModel($productFormat);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductFormatUpdateAction::class)($productFormat, $data);

    $productFormat->refresh();

    expect($productFormat)
        ->title->toEqual($newFieldValue);
});

test('productFormat delete action', function () {
    $productFormat = ProductFormat::factory()->create();

    app(ProductFormatDeleteAction::class)($productFormat);

    $this->assertModelMissing($productFormat);
});

test('productFormat field enum labels', function () {
    app()->setLocale('en');

    expect(ProductFormatFieldEnum::labels())->toBe([
        'id' => 'Id',
        'product_id' => 'Product',
        'product.title' => 'Product Title',
        'title' => 'Title',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productFormat rules key is prepended', function () {
    expect(array_keys(ProductFormatRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productFormat.');
});

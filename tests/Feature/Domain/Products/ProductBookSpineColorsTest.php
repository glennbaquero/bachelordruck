<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductBookSpineColorCreateAction;
use Domain\Products\Actions\ProductBookSpineColorDeleteAction;
use Domain\Products\Actions\ProductBookSpineColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\FieldEnums\ProductBookSpineColorFieldEnum;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\Rules\ProductBookSpineColorRules;

test('create productBookSpineColor data from model', function () {
    /** @var ProductBookSpineColor $productBookSpineColor */
    $productBookSpineColor = ProductBookSpineColor::factory()->make();

    $data = ProductBookSpineColorData::fromModel($productBookSpineColor);

    expect($data)
        ->product_id->toEqual($productBookSpineColor->product_id)
        ->title->toEqual($productBookSpineColor->title)
        ->color->toEqual($productBookSpineColor->color)
        ->is_preselected->toEqual($productBookSpineColor->is_preselected)
        ->sort->toEqual($productBookSpineColor->sort)
        ->status->toEqual($productBookSpineColor->status);
});

test('productBookSpineColor create action', function () {
    $productBookSpineColor = ProductBookSpineColor::factory()->make();

    $data = ProductBookSpineColorData::fromModel($productBookSpineColor);

    app(ProductBookSpineColorCreateAction::class)($data);

    $this->assertDatabaseHas('product_book_spine_colors', $data->toArray());
});

test('productBookSpineColor update action', function () {
    $productBookSpineColor = ProductBookSpineColor::factory()->create();

    $data = ProductBookSpineColorData::fromModel($productBookSpineColor);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductBookSpineColorUpdateAction::class)($productBookSpineColor, $data);

    $productBookSpineColor->refresh();

    expect($productBookSpineColor)
        ->title->toEqual($newFieldValue);
});

test('productBookSpineColor delete action', function () {
    $productBookSpineColor = ProductBookSpineColor::factory()->create();

    app(ProductBookSpineColorDeleteAction::class)($productBookSpineColor);

    $this->assertModelMissing($productBookSpineColor);
});

test('productBookSpineColor field enum labels', function () {
    app()->setLocale('en');

    expect(ProductBookSpineColorFieldEnum::labels())->toBe([
        'id' => 'Id',
        'product_id' => 'Product',
        'product.title' => 'Product Title',
        'title' => 'Title',
        'color' => 'Color',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
        'image' => 'Image',
    ]);
});

test('productBookSpineColor rules key is prepended', function () {
    expect(array_keys(ProductBookSpineColorRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productBookSpineColor.');
});

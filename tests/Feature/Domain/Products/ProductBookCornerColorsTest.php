<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductBookCornerColorCreateAction;
use Domain\Products\Actions\ProductBookCornerColorDeleteAction;
use Domain\Products\Actions\ProductBookCornerColorUpdateAction;
use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\FieldEnums\ProductBookCornerColorFieldEnum;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Rules\ProductBookCornerColorRules;

test('create productBookCornerColor data from model', function () {
    $productBookCornerColor = ProductBookCornerColor::factory()->make();

    $data = ProductBookCornerColorData::fromModel($productBookCornerColor);

    expect($data)
        ->title->toEqual($productBookCornerColor->title)
        ->color->toEqual($productBookCornerColor->color)
        ->is_preselected->toEqual($productBookCornerColor->is_preselected)
        ->sort->toEqual($productBookCornerColor->sort)
        ->status->toEqual($productBookCornerColor->status);
});

test('productBookCornerColor create action', function () {
    /** @var ProductBookCornerColor $productBookCornerColor */
    $productBookCornerColor = ProductBookCornerColor::factory()->make();

    $data = ProductBookCornerColorData::fromModel($productBookCornerColor);

    app(ProductBookCornerColorCreateAction::class)($data);

    $this->assertDatabaseHas('product_book_corner_colors', $data->toArray());
});

test('productBookCornerColor update action', function () {
    $productBookCornerColor = ProductBookCornerColor::factory()->create();

    $data = ProductBookCornerColorData::fromModel($productBookCornerColor);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductBookCornerColorUpdateAction::class)($productBookCornerColor, $data);

    $productBookCornerColor->refresh();

    expect($productBookCornerColor)
        ->title->toEqual($newFieldValue);
});

test('productBookCornerColor delete action', function () {
    $productBookCornerColor = ProductBookCornerColor::factory()->create();

    app(ProductBookCornerColorDeleteAction::class)($productBookCornerColor);

    $this->assertModelMissing($productBookCornerColor);
});

test('productBookCornerColor field enum labels', function () {
    app()->setLocale('en');

    expect(ProductBookCornerColorFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'color' => 'Color',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productBookCornerColor rules key is prepended', function () {
    expect(array_keys(ProductBookCornerColorRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productBookCornerColor.');
});

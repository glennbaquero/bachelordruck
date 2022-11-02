<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductPaperThicknessCreateAction;
use Domain\Products\Actions\ProductPaperThicknessDeleteAction;
use Domain\Products\Actions\ProductPaperThicknessUpdateAction;
use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\FieldEnums\ProductPaperThicknessFieldEnum;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Rules\ProductPaperThicknessRules;

test('create productPaperThickness data from model', function () {
    $productPaperThickness = ProductPaperThickness::factory()->make();

    $data = ProductPaperThicknessData::fromModel($productPaperThickness);

    expect($data)
        ->product_id->toEqual($productPaperThickness->product_id)
        ->title->toEqual($productPaperThickness->title)
        ->tooltip->toEqual($productPaperThickness->tooltip)
        ->max_pages->toEqual($productPaperThickness->max_pages)
        ->price_per_page_bw->toEqual($productPaperThickness->price_per_page_bw)
        ->price_per_page_color->toEqual($productPaperThickness->price_per_page_color)
        ->is_preselected->toEqual($productPaperThickness->is_preselected)
        ->sort->toEqual($productPaperThickness->sort)
        ->status->toEqual($productPaperThickness->status);
});

test('productPaperThickness create action', function () {
    /** @var ProductPaperThickness $productPaperThickness */
    $productPaperThickness = ProductPaperThickness::factory()->make();

    $data = ProductPaperThicknessData::fromModel($productPaperThickness);

    app(ProductPaperThicknessCreateAction::class)($data);

    $data->price_per_page_bw *= 100;
    $data->price_per_page_color *= 100;

    $this->assertDatabaseHas('product_paper_thicknesses', $data->toArray());
});

test('productPaperThickness update action', function () {
    $productPaperThickness = ProductPaperThickness::factory()->create();

    $data = ProductPaperThicknessData::fromModel($productPaperThickness);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductPaperThicknessUpdateAction::class)($productPaperThickness, $data);

    $productPaperThickness->refresh();

    expect($productPaperThickness)
        ->title->toEqual($newFieldValue);
});

test('productPaperThickness delete action', function () {
    $productPaperThickness = ProductPaperThickness::factory()->create();

    app(ProductPaperThicknessDeleteAction::class)($productPaperThickness);

    $this->assertModelMissing($productPaperThickness);
});

test('productPaperThickness field enum labels', function () {
    app()->setLocale('en');

    expect(ProductPaperThicknessFieldEnum::labels())->toBe([
        'id' => 'Id',
        'product_id' => 'Product',
        'product.title' => 'Product Title',
        'title' => 'Title',
        'tooltip' => 'Tooltip',
        'max_pages' => 'Max Pages',
        'price_per_page_bw' => 'Price per page black and white',
        'price_per_page_color' => 'Price per page colored',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productPaperThickness rules key is prepended', function () {
    expect(array_keys(ProductPaperThicknessRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productPaperThickness.');
});

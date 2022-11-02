<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductCreateAction;
use Domain\Products\Actions\ProductDeleteAction;
use Domain\Products\Actions\ProductUpdateAction;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\FieldEnums\ProductFieldEnum;
use Domain\Products\Models\Product;
use Domain\Products\Rules\ProductRules;

test('create product data from model', function () {
    /** @var Product $product */
    $product = Product::factory()->make();

    $data = ProductData::fromModel($product);

    expect($data)
        ->title->toEqual($product->title)
        ->tooltip->toEqual($product->tooltip)
        ->description->toEqual($product->description)
        ->price->toEqual($product->price)
        ->has_cover_color->toEqual($product->has_cover_color)
        ->has_cover_imprint_color->toEqual($product->has_cover_imprint_color)
        ->has_cover_foil->toEqual($product->has_cover_foil)
        ->has_book_spine_label->toEqual($product->has_book_spine_label)
        ->book_spine_label_surcharge->toEqual($product->book_spine_label_surcharge)
        ->has_book_corners->toEqual($product->has_book_corners)
        ->book_corners_surcharge->toEqual($product->book_corners_surcharge)
        ->has_ribbon->toEqual($product->has_ribbon)
        ->ribbon_surcharge->toEqual($product->ribbon_surcharge)
        ->sort->toEqual($product->sort)
        ->status->toEqual($product->status);
});

test('product create action', function () {
    $product = Product::factory()->make([
        'slug' => null,
        'title' => 'product 1',
    ]);

    $data = ProductData::fromModel($product);

    app(ProductCreateAction::class)($data);

    $data->price *= 100;
    $data->book_spine_label_surcharge *= 100;
    $data->book_corners_surcharge *= 100;
    $data->ribbon_surcharge *= 100;
    $data->slug = 'product-1';

    $this->assertDatabaseHas('products', $data->toArray());
});

test('product update action', function () {
    $product = Product::factory()->create();

    $data = ProductData::fromModel($product);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductUpdateAction::class)($product, $data);

    $product->refresh();

    expect($product)
        ->title->toEqual($newFieldValue);
});

test('product delete action', function () {
    $product = Product::factory()->create();

    app(ProductDeleteAction::class)($product);

    $this->assertModelMissing($product);
});

test('product field enum labels', function () {
    app()->setLocale('en');

    expect(ProductFieldEnum::labels())->toBe([
        'id' => 'Id',
        'slug' => 'Slug',
        'title' => 'Title',
        'tooltip' => 'Tooltip',
        'description' => 'Description',
        'price' => 'Price',
        'has_cover_color' => 'Has Cover Color',
        'has_cover_imprint_color' => 'Has Cover Imprint Color',
        'has_cover_foil' => 'Has Cover Foild',
        'has_back_cover' => 'Has Back Cover',
        'has_book_spine_label' => 'Has Book Spine Label',
        'book_spine_label_surcharge' => 'Book Spine Label Surcharge',
        'has_book_corners' => 'Has Book Corners',
        'book_corners_surcharge' => 'Book Corners Surcharge',
        'has_ribbon' => 'Has Ribbon',
        'ribbon_surcharge' => 'Ribbon Surcharge',
        'sort' => 'Sort',
        'status' => 'Status',
        'image' => 'Image',
    ]);
});

test('product rules key is prepended', function () {
    expect(array_keys(ProductRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('product.');
});

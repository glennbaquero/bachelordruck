<?php

namespace Tests\Feature\Domain\Products;

use Domain\Products\Actions\ProductBackCoverCreateAction;
use Domain\Products\Actions\ProductBackCoverDeleteAction;
use Domain\Products\Actions\ProductBackCoverUpdateAction;
use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\FieldEnums\ProductBackCoverFieldEnum;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Rules\ProductBackCoverRules;

test('create productBackCover data from model', function () {
    $productBackCover = ProductBackCover::factory()->make();

    $data = ProductBackCoverData::fromModel($productBackCover);

    expect($data)
        ->title->toEqual($productBackCover->title)
        ->color->toEqual($productBackCover->color)
        ->is_preselected->toEqual($productBackCover->is_preselected)
        ->sort->toEqual($productBackCover->sort)
        ->status->toEqual($productBackCover->status);
});

test('productBackCover create action', function () {
    /** @var ProductBackCover $productBackCover */
    $productBackCover = ProductBackCover::factory()->make();

    $data = ProductBackCoverData::fromModel($productBackCover);

    app(ProductBackCoverCreateAction::class)($data);

    $this->assertDatabaseHas('product_back_covers', $data->toArray());
});

test('productBackCover update action', function () {
    $productBackCover = ProductBackCover::factory()->create();

    $data = ProductBackCoverData::fromModel($productBackCover);

    $newFieldValue = 'Test Edit';

    $data->title = $newFieldValue;

    app(ProductBackCoverUpdateAction::class)($productBackCover, $data);

    $productBackCover->refresh();

    expect($productBackCover)
        ->title->toEqual($newFieldValue);
});

test('productBackCover delete action', function () {
    $productBackCover = ProductBackCover::factory()->create();

    app(ProductBackCoverDeleteAction::class)($productBackCover);

    $this->assertModelMissing($productBackCover);
});

test('productBackCover field enum labels', function () {
    app()->setLocale('en');

    expect(ProductBackCoverFieldEnum::labels())->toBe([
        'id' => 'Id',
        'title' => 'Title',
        'color' => 'Color',
        'is_preselected' => 'Is Pre-selected',
        'sort' => 'Sort',
        'status' => 'Status',
    ]);
});

test('productBackCover rules key is prepended', function () {
    expect(array_keys(ProductBackCoverRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('productBackCover.');
});

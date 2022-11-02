<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\OrderPositionConfigurationUpdateAction;
use Domain\Orders\Actions\OrderPositionCreateAction;
use Domain\Orders\Actions\OrderPositionDeleteAction;
use Domain\Orders\Actions\OrderPositionUpdateAction;
use Domain\Orders\DataTransferObjects\OrderPositionData;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\OrderPosition;
use Domain\Orders\Rules\OrderPositionRules;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\Models\Product;

test('create orderPosition data from model', function () {
    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var OrderPosition $orderPosition */
    $orderPosition = OrderPosition::factory()->make([
        'session_id' => session()->getId(),
        'configuration' => [
            'product_id' => $product->id,
        ],
        'product_data' => $product->toArray(),
    ]);

    $productData = ProductData::fromModel($product);
    $productConfigurationData = new ProductConfigurationData($orderPosition->configuration);

    $data = OrderPositionData::fromModel($orderPosition);

    expect($data)
        ->order_id->toEqual($orderPosition->order_id)
        ->product_id->toEqual($orderPosition->product_id)
        ->qty->toEqual($orderPosition->qty)
        ->configuration->toEqual($productConfigurationData)
        ->product_data->toEqual($productData)
        ->price->toEqual($orderPosition->price);
});

test('orderPosition create action', function () {
    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var OrderPosition $orderPosition */
    $orderPosition = OrderPosition::factory()->make([
        'configuration' => [
            'product_id' => $product->id,
        ],
        'product_data' => $product->toArray(),
    ]);

    $data = OrderPositionData::fromModel($orderPosition);

    app(OrderPositionCreateAction::class)($data);

    $dataArray = $data->toArray();

    unset($dataArray['configuration'], $dataArray['product_data']);

    $dataArray['price'] *= 100;

    $this->assertDatabaseHas('order_positions', $dataArray);
});

test('orderPosition update action', function () {
    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var OrderPosition $orderPosition */
    $orderPosition = OrderPosition::factory()->make([
        'qty' => 2,
        'configuration' => [
            'product_id' => $product->id,
        ],
        'product_data' => $product->toArray(),
    ]);

    $data = OrderPositionData::fromModel($orderPosition);

    $newFieldValue = 3;

    $data->qty = $newFieldValue;

    app(OrderPositionUpdateAction::class)($orderPosition, $data);

    $orderPosition->refresh();

    expect($orderPosition)
        ->qty->toEqual($newFieldValue);
});

test('orderPosition configuration update action', function () {
    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var OrderPosition $orderPosition */
    $orderPosition = OrderPosition::factory()->make([
        'qty' => 2,
        'configuration' => [
            'product_id' => $product->id,
            'include_print_file' => false,
        ],
        'product_data' => $product->toArray(),
    ]);

    $data = OrderPositionData::fromModel($orderPosition);

    app(OrderPositionConfigurationUpdateAction::class)($orderPosition, ['include_print_file' => true]);

    $orderPosition->refresh();

    expect($orderPosition['configuration'])
        ->include_print_file->toBeTrue();

    app(OrderPositionConfigurationUpdateAction::class)($orderPosition, ['include_print_file' => false]);

    $orderPosition->refresh();

    expect($orderPosition['configuration'])
        ->include_print_file->toBeFalse();
});

test('orderPosition delete action', function () {
    $orderPosition = OrderPosition::factory()->create();

    app(OrderPositionDeleteAction::class)($orderPosition);

    $this->assertModelMissing($orderPosition);
});

test('orderPosition field enum labels', function () {
    app()->setLocale('en');

    expect(OrderPositionFieldEnum::labels())->toBe([
        // 'id' => 'Id',
    ]);
})->skip();

test('orderPosition rules key is prepended', function () {
    expect(array_keys(OrderPositionRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('orderPosition.');
});

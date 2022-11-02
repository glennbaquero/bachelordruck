<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Collections\BasketPositionCollection;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Services\BasketService;
use Domain\Products\Models\Product;

test('BasketService add, get, collection totals, update and delete functionalities for single basket item', function () {
    // Add
    $sessionId = session()->getId();

    /** @var Product $product */
    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var BasketPosition $basketPosition */
    $basketPosition = BasketPosition::factory()->make([
        'product_id' => $product->id,
        'price' => $product->price,
        'qty' => 2,
        'session_id' => $sessionId,
        'configuration' => [
            'product_id' => $product->id,
        ],
    ]);

    $productConfigurationData = ProductConfigurationData::create(
        product_id: $basketPosition->product_id,
        has_book_spine_label: true,
    );

    BasketService::session($sessionId)
        ->add($basketPosition, $productConfigurationData);

    /** @var BasketPosition $addedBasketPosition */
    $addedBasketPosition = BasketPosition::query()
        ->where('session_id', $sessionId)
        ->where('product_id', $product->id)
        ->first();

    expect($addedBasketPosition)
        ->price->toEqual($product->price)
        ->qty->toEqual(2)
        ->configuration->toEqual($productConfigurationData->all());

    // Get
    /** @var BasketPositionCollection $basketPositions */
    $basketPositions = BasketService::session($sessionId)->get();

    expect($basketPositions->first())
        ->price->toEqual($product->price)
        ->qty->toEqual(2)
        ->configuration->toEqual($productConfigurationData->all());

    // Collection Totals
    expect($basketPositions->totalQuantity())->toEqual(2);
    expect($basketPositions->totalCost())->toEqual(5600);

    // Update
    $addedBasketPosition->qty = 3;

    BasketService::session($sessionId)
        ->update($addedBasketPosition, new ProductConfigurationData($addedBasketPosition->configuration));

    $addedBasketPosition->refresh();

    expect($addedBasketPosition)
        ->price->toEqual($product->price)
        ->qty->toEqual(3)
        ->configuration->toEqual($productConfigurationData->all());

    // Delete
    BasketService::session($sessionId)
        ->remove($addedBasketPosition);

    $this->assertModelMissing($addedBasketPosition);
});

test('BasketService add, get, collection totals functionalities for multiple basket item', function () {
    // Add
    $sessionId = session()->getId();

    /** @var Product $product1 */
    $product1 = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var BasketPosition $basketPosition1 */
    $basketPosition1 = BasketPosition::factory()->make([
        'product_id' => $product1->id,
        'price' => $product1->price,
        'qty' => 2,
        'session_id' => $sessionId,
        'configuration' => [
            'product_id' => $product1->id,
        ],
    ]);

    $productConfigurationData1 = ProductConfigurationData::create(
        product_id: $basketPosition1->product_id,
        has_book_spine_label: true,
    );

    BasketService::session($sessionId)
        ->add($basketPosition1, $productConfigurationData1);

    /** @var BasketPosition $addedBasketPosition1 */
    $addedBasketPosition1 = BasketPosition::query()
        ->where('session_id', $sessionId)
        ->where('product_id', $product1->id)
        ->first();

    expect($addedBasketPosition1)
        ->price->toEqual($product1->price)
        ->qty->toEqual(2)
        ->configuration->toEqual($productConfigurationData1->all());

    /** @var Product $product2 */
    $product2 = Product::factory()->create([
        'price' => 1000,
    ]);

    /** @var BasketPosition $basketPosition2 */
    $basketPosition2 = BasketPosition::factory()->make([
        'product_id' => $product2->id,
        'price' => $product2->price,
        'qty' => 4,
        'session_id' => $sessionId,
        'configuration' => [
            'product_id' => $product2->id,
        ],
    ]);

    $productConfigurationData2 = ProductConfigurationData::create(
        product_id: $basketPosition2->product_id,
        has_book_spine_label: true,
    );

    BasketService::session($sessionId)
        ->add($basketPosition2, $productConfigurationData2);

    /** @var BasketPosition $addedBasketPosition1 */
    $addedBasketPosition2 = BasketPosition::query()
        ->where('session_id', $sessionId)
        ->where('product_id', $product2->id)
        ->first();

    expect($addedBasketPosition2)
        ->price->toEqual($product2->price)
        ->qty->toEqual(4)
        ->configuration->toEqual($productConfigurationData2->all());

    // Get
    /** @var BasketPositionCollection $basketPositions */
    $basketPositions = BasketService::session($sessionId)->get();

    expect($basketPositions[1])
        ->price->toEqual($product2->price)
        ->qty->toEqual(4)
        ->configuration->toEqual($productConfigurationData2->all());

    // Collection Totals
    expect($basketPositions->totalQuantity())->toEqual(6);
    expect($basketPositions->totalCost())->toEqual(9600);
});

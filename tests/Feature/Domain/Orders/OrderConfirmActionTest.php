<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\OrderConfirmAction;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Models\Order;
use Domain\Orders\Services\BasketService;
use Domain\Products\Models\Product;

it('confirms order', function () {
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

    $order = Order::factory()->create([
        'session_id' => $sessionId,
    ]);

    app(OrderConfirmAction::class)($order);

    $order->refresh();
    $order->load('orderPositions');

    expect($order->orderPositions->first())
        ->product_id->toBe($product->id)
        ->price->toBe($product->price)
        ->qty->toBe(2);

    expect($order)
        ->total_amount
        ->toBe(5992);

    // Basket Position session is now deleted.
    expect(BasketPosition::where('session_id', $sessionId)->count())
        ->toBe(0);
});

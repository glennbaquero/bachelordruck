<?php

use Domain\Orders\Actions\OrderPositionCreateAction;
use Domain\Orders\DataTransferObjects\OrderPositionData;
use Domain\Orders\Jobs\SendOrderCompleteMail;
use Domain\Orders\Mailables\OrderCompleteMailable;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderPosition;
use Domain\Products\Models\Product;

it('send order complete mail to a customer', function () {
    Mail::fake();

    $order = Order::factory()->create();

    $product = Product::factory()->create([
        'price' => 2800,
    ]);

    /** @var OrderPosition $orderPosition */
    $orderPosition = OrderPosition::factory()->make([
        'order_id' => $order->id,
        'qty' => 2,
        'configuration' => [
            'product_id' => $product->id,
            'include_print_file' => false,
        ],
        'product_data' => $product->toArray(),
    ]);

    $orderPositionData = OrderPositionData::fromModel($orderPosition);

    app(OrderPositionCreateAction::class)($orderPositionData);

    SendOrderCompleteMail::dispatch($order);

    Mail::assertSent(OrderCompleteMailable::class, function ($mail) use ($order) {
        expect($mail->to[0]['address'])->toEqual($order->email);

        return $mail;
    });
});

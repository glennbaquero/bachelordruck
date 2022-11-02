<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Collections\BasketPositionCollection;
use Domain\Orders\DataTransferObjects\OrderPositionData;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Models\Order;
use Domain\Products\DataTransferObjects\ProductData;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class OrderConfirmAction
{
    /**
     * @throws UnknownProperties
     */
    public function __invoke(Order $order): Order
    {
        /** @var BasketPositionCollection $basketPositions */
        $basketPositions = BasketPosition::query()
            ->where('session_id', $order->session_id)
            ->with('product')
            ->get();

        // Save each Basket Position
        foreach ($basketPositions as $basketPosition) {
            $orderPosition = OrderPositionData::create(
                order_id: $order->id,
                product_id: $basketPosition->product_id,
                price: $basketPosition->price,
                qty: $basketPosition->qty,
                configuration: new ProductConfigurationData($basketPosition->configuration),
                product_data: ProductData::fromModel($basketPosition->product),
            );

            app(OrderPositionCreateAction::class)($orderPosition);
        }

        // Update Total Amount
        $order->total_amount = $basketPositions->gross();
        $order->save();

        // Delete Basket Position
        BasketPosition::query()
            ->where('session_id', $order->session_id)
            ->delete();

        return $order;
    }
}

<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Models\Order;

class OrderStatusUpdateAction
{
    public function __invoke(Order $order, OrderData $orderData): Order
    {
        $order->status = $orderData->status;

        $order->save();

        return $order->refresh();
    }
}

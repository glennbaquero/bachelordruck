<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;

class OrderCompleteAction
{
    public function __invoke(Order $order): Order
    {
        $order->completed_at = now();
        $order->status = StatusEnum::READY_FOR_PRODUCTION;

        $order->save();

        return $order;
    }
}

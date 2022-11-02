<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Order;

class OrderDeleteAction
{
    public function __invoke(Order $order): void
    {
        $order->delete();
    }
}

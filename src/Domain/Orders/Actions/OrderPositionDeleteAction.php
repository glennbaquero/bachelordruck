<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\OrderPosition;

class OrderPositionDeleteAction
{
    public function __invoke(OrderPosition $orderPosition): void
    {
        $orderPosition->delete();
    }
}

<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderPositionData;
use Domain\Orders\Models\OrderPosition;

class OrderPositionCreateAction
{
    public function __invoke(OrderPositionData $orderPositionData): OrderPosition
    {
        return OrderPosition::create([
            'order_id' => $orderPositionData->order_id,
            'product_id' => $orderPositionData->product_id,
            'qty' => $orderPositionData->qty,
            'configuration' => $orderPositionData->configuration,
            'product_data' => $orderPositionData->product_data,
            'price' => $orderPositionData->price,
        ]);
    }
}

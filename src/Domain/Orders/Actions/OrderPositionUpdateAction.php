<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderPositionData;
use Domain\Orders\Models\OrderPosition;

class OrderPositionUpdateAction
{
    public function __invoke(OrderPosition $orderPosition, OrderPositionData $orderPositionData): OrderPosition
    {
        $orderPosition->order_id = $orderPositionData->order_id;
        $orderPosition->product_id = $orderPositionData->product_id;
        $orderPosition->qty = $orderPositionData->qty;
        $orderPosition->configuration = $orderPositionData->configuration;
        $orderPosition->product_data = $orderPositionData->product_data;
        $orderPosition->price = $orderPositionData->price;

        $orderPosition->save();

        return $orderPosition->refresh();
    }
}

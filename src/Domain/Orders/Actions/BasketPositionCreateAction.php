<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\BasketPositionData;
use Domain\Orders\Models\BasketPosition;

class BasketPositionCreateAction
{
    public function __invoke(BasketPositionData $basketPositionData): BasketPosition
    {
        return BasketPosition::create([
            'session_id' => $basketPositionData->session_id,
            'product_id' => $basketPositionData->product_id,
            'qty' => $basketPositionData->qty,
            'configuration' => $basketPositionData->configuration,
            'price' => $basketPositionData->price,
        ]);
    }
}

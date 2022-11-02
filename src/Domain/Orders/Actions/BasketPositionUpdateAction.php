<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\BasketPositionData;
use Domain\Orders\Models\BasketPosition;

class BasketPositionUpdateAction
{
    public function __invoke(BasketPosition $basketPosition, BasketPositionData $basketPositionData): BasketPosition
    {
        $basketPosition->session_id = $basketPositionData->session_id;
        $basketPosition->product_id = $basketPositionData->product_id;
        $basketPosition->qty = $basketPositionData->qty;
        $basketPosition->configuration = $basketPositionData->configuration;
        $basketPosition->price = $basketPositionData->price;

        $basketPosition->save();

        return $basketPosition->refresh();
    }
}

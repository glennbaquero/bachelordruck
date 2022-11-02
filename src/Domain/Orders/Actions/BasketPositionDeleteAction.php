<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\BasketPosition;

class BasketPositionDeleteAction
{
    public function __invoke(BasketPosition $basketPosition): void
    {
        $basketPosition->delete();
    }
}

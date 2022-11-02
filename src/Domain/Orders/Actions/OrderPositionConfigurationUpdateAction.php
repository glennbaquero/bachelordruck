<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\OrderPosition;

class OrderPositionConfigurationUpdateAction
{
    public function __invoke(OrderPosition $orderPosition, array $newProductConfiguration): OrderPosition
    {
        $orderPosition->configuration = [...$orderPosition->configuration, ...$newProductConfiguration];
        $orderPosition->save();

        return $orderPosition;
    }
}

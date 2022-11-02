<?php

namespace Domain\Orders\Traits;

use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Models\OrderPosition;
use Support\Helpers\Decimals;
use Support\Helpers\VatHelpers;

trait HasPositionCollection
{
    public function totalQuantity(): float|int
    {
        return $this->sum('qty');
    }

    public function totalCost(): float|int
    {
        return $this->reduce(function (float|int $cost, OrderPosition|BasketPosition $basketPosition) {
            return $cost + ($basketPosition->price * $basketPosition->qty);
        }, 0);
    }

    public function gross(): float
    {
        return VatHelpers::computeGross($this->totalCost(), 0.07);
    }

    /**
     * @throws \Exception
     */
    public function totalCostFormatted(): string
    {
        return Decimals::format($this->totalCost());
    }

    /**
     * @throws \Exception
     */
    public function grossFormatted(): string
    {
        return Decimals::format($this->gross());
    }
}

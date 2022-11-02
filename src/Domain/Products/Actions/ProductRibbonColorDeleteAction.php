<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductRibbonColor;

class ProductRibbonColorDeleteAction
{
    public function __invoke(ProductRibbonColor $productRibbonColor): void
    {
        $productRibbonColor->delete();
    }
}

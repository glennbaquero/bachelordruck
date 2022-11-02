<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductCoverFoil;

class ProductCoverFoilDeleteAction
{
    public function __invoke(ProductCoverFoil $productCoverFoil): void
    {
        $productCoverFoil->delete();
    }
}

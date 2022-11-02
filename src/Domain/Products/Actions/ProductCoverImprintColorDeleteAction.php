<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductCoverImprintColor;

class ProductCoverImprintColorDeleteAction
{
    public function __invoke(ProductCoverImprintColor $productCoverImprintColor): void
    {
        $productCoverImprintColor->delete();
    }
}

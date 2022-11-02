<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductFormat;

class ProductFormatDeleteAction
{
    public function __invoke(ProductFormat $productFormat): void
    {
        $productFormat->delete();
    }
}

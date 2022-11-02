<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Product;

class ProductDeleteAction
{
    public function __invoke(Product $product): void
    {
        $product->delete();
    }
}

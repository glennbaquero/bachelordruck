<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductBookSpineColor;

class ProductBookSpineColorDeleteAction
{
    public function __invoke(ProductBookSpineColor $productBookSpineColor): void
    {
        $productBookSpineColor->delete();
    }
}

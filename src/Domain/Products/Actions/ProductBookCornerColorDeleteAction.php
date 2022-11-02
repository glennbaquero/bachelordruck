<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductBookCornerColor;

class ProductBookCornerColorDeleteAction
{
    public function __invoke(ProductBookCornerColor $productBookCornerColor): void
    {
        $productBookCornerColor->delete();
    }
}

<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductPaperThickness;

class ProductPaperThicknessDeleteAction
{
    public function __invoke(ProductPaperThickness $productPaperThickness): void
    {
        $productPaperThickness->delete();
    }
}

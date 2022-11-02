<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductCoverColor;

class ProductCoverColorDeleteAction
{
    public function __invoke(ProductCoverColor $productCoverColor): void
    {
        $productCoverColor->delete();
    }
}

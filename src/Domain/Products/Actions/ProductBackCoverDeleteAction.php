<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\ProductBackCover;

class ProductBackCoverDeleteAction
{
    public function __invoke(ProductBackCover $productBackCover): void
    {
        $productBackCover->delete();
    }
}

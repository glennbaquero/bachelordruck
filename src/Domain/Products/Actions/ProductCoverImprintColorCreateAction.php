<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\Models\ProductCoverImprintColor;

class ProductCoverImprintColorCreateAction
{
    public function __invoke(ProductCoverImprintColorData $productCoverImprintColorData): ProductCoverImprintColor
    {
        return ProductCoverImprintColor::create([
            'title' => $productCoverImprintColorData->title,
            'color' => $productCoverImprintColorData->color,
            'is_preselected' => $productCoverImprintColorData->is_preselected,
            'sort' => $productCoverImprintColorData->sort,
            'status' => $productCoverImprintColorData->status,
        ]);
    }
}

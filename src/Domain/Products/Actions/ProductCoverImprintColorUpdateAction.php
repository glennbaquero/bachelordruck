<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\Models\ProductCoverImprintColor;

class ProductCoverImprintColorUpdateAction
{
    public function __invoke(ProductCoverImprintColor $productCoverImprintColor, ProductCoverImprintColorData $productCoverImprintColorData): ProductCoverImprintColor
    {
        $productCoverImprintColor->title = $productCoverImprintColorData->title;
        $productCoverImprintColor->color = $productCoverImprintColorData->color;
        $productCoverImprintColor->is_preselected = $productCoverImprintColorData->is_preselected;
        $productCoverImprintColor->sort = $productCoverImprintColorData->sort;
        $productCoverImprintColor->status = $productCoverImprintColorData->status;

        $productCoverImprintColor->save();

        return $productCoverImprintColor->refresh();
    }
}

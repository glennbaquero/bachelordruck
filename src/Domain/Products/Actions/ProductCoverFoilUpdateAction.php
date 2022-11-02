<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\Models\ProductCoverFoil;

class ProductCoverFoilUpdateAction
{
    public function __invoke(ProductCoverFoil $productCoverFoil, ProductCoverFoilData $productCoverFoilData): ProductCoverFoil
    {
        app(PreSelectedFieldResetAction::class)($productCoverFoil, $productCoverFoilData->is_preselected);

        $productCoverFoil->title = $productCoverFoilData->title;
        $productCoverFoil->is_preselected = $productCoverFoilData->is_preselected;
        $productCoverFoil->sort = $productCoverFoilData->sort;
        $productCoverFoil->status = $productCoverFoilData->status;

        $productCoverFoil->save();

        return $productCoverFoil->refresh();
    }
}

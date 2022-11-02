<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\Models\ProductCoverFoil;

class ProductCoverFoilCreateAction
{
    public function __invoke(ProductCoverFoilData $productCoverFoilData): ProductCoverFoil
    {
        app(PreSelectedFieldResetAction::class)(ProductCoverFoil::newModelInstance(), $productCoverFoilData->is_preselected);

        return ProductCoverFoil::create([
            'title' => $productCoverFoilData->title,
            'is_preselected' => $productCoverFoilData->is_preselected,
            'sort' => $productCoverFoilData->sort,
            'status' => $productCoverFoilData->status,
        ]);
    }
}

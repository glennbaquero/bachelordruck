<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\Models\ProductRibbonColor;

class ProductRibbonColorCreateAction
{
    public function __invoke(ProductRibbonColorData $productRibbonColorData): ProductRibbonColor
    {
        app(PreSelectedFieldResetAction::class)(ProductRibbonColor::newModelInstance(), $productRibbonColorData->is_preselected);

        return ProductRibbonColor::create([
            'title' => $productRibbonColorData->title,
            'color' => $productRibbonColorData->color,
            'is_preselected' => $productRibbonColorData->is_preselected,
            'sort' => $productRibbonColorData->sort,
            'status' => $productRibbonColorData->status,
        ]);
    }
}

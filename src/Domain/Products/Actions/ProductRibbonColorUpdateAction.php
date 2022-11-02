<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\Models\ProductRibbonColor;

class ProductRibbonColorUpdateAction
{
    public function __invoke(ProductRibbonColor $productRibbonColor, ProductRibbonColorData $productRibbonColorData): ProductRibbonColor
    {
        app(PreSelectedFieldResetAction::class)($productRibbonColor, $productRibbonColorData->is_preselected);

        $productRibbonColor->title = $productRibbonColorData->title;
        $productRibbonColor->color = $productRibbonColorData->color;
        $productRibbonColor->is_preselected = $productRibbonColorData->is_preselected;
        $productRibbonColor->sort = $productRibbonColorData->sort;
        $productRibbonColor->status = $productRibbonColorData->status;

        $productRibbonColor->save();

        return $productRibbonColor->refresh();
    }
}

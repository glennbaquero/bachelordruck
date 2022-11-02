<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\Models\ProductBookSpineColor;

class ProductBookSpineColorUpdateAction
{
    public function __invoke(ProductBookSpineColor $productBookSpineColor, ProductBookSpineColorData $productBookSpineColorData): ProductBookSpineColor
    {
        app(PreSelectedFieldResetAction::class)($productBookSpineColor, $productBookSpineColorData->is_preselected, 'product_id');

        $productBookSpineColor->product_id = $productBookSpineColorData->product_id;
        $productBookSpineColor->title = $productBookSpineColorData->title;
        $productBookSpineColor->color = $productBookSpineColorData->color;
        $productBookSpineColor->is_preselected = $productBookSpineColorData->is_preselected;
        $productBookSpineColor->sort = $productBookSpineColorData->sort;
        $productBookSpineColor->status = $productBookSpineColorData->status;

        $productBookSpineColor->save();

        return $productBookSpineColor->refresh();
    }
}

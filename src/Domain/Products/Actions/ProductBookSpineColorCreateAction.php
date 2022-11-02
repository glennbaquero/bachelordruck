<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\Models\ProductBookSpineColor;

class ProductBookSpineColorCreateAction
{
    public function __invoke(ProductBookSpineColorData $productBookSpineColorData): ProductBookSpineColor
    {
        app(PreSelectedFieldResetAction::class)(ProductBookSpineColor::newModelInstance(['product_id' => $productBookSpineColorData->product_id]), $productBookSpineColorData->is_preselected, 'product_id');

        return ProductBookSpineColor::create([
            'product_id' => $productBookSpineColorData->product_id,
            'title' => $productBookSpineColorData->title,
            'color' => $productBookSpineColorData->color,
            'is_preselected' => $productBookSpineColorData->is_preselected,
            'sort' => $productBookSpineColorData->sort,
            'status' => $productBookSpineColorData->status,
        ]);
    }
}

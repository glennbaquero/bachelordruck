<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\Models\ProductBookCornerColor;

class ProductBookCornerColorCreateAction
{
    public function __invoke(ProductBookCornerColorData $productBookCornerColorData): ProductBookCornerColor
    {
        app(PreSelectedFieldResetAction::class)(ProductBookCornerColor::newModelInstance(), $productBookCornerColorData->is_preselected);

        return ProductBookCornerColor::create([
            'title' => $productBookCornerColorData->title,
            'color' => $productBookCornerColorData->color,
            'is_preselected' => $productBookCornerColorData->is_preselected,
            'sort' => $productBookCornerColorData->sort,
            'status' => $productBookCornerColorData->status,
        ]);
    }
}

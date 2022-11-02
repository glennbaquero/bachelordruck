<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\Models\ProductBookCornerColor;

class ProductBookCornerColorUpdateAction
{
    public function __invoke(ProductBookCornerColor $productBookCornerColor, ProductBookCornerColorData $productBookCornerColorData): ProductBookCornerColor
    {
        app(PreSelectedFieldResetAction::class)($productBookCornerColor, $productBookCornerColorData->is_preselected);

        $productBookCornerColor->title = $productBookCornerColorData->title;
        $productBookCornerColor->color = $productBookCornerColorData->color;
        $productBookCornerColor->is_preselected = $productBookCornerColorData->is_preselected;
        $productBookCornerColor->sort = $productBookCornerColorData->sort;
        $productBookCornerColor->status = $productBookCornerColorData->status;

        $productBookCornerColor->save();

        return $productBookCornerColor->refresh();
    }
}

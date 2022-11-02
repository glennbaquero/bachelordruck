<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\Models\ProductPaperThickness;

class ProductPaperThicknessUpdateAction
{
    public function __invoke(ProductPaperThickness $productPaperThickness, ProductPaperThicknessData $productPaperThicknessData): ProductPaperThickness
    {
        app(PreSelectedFieldResetAction::class)($productPaperThickness, $productPaperThicknessData->is_preselected, 'product_id');

        $productPaperThickness->product_id = $productPaperThicknessData->product_id;
        $productPaperThickness->title = $productPaperThicknessData->title;
        $productPaperThickness->tooltip = $productPaperThicknessData->tooltip;
        $productPaperThickness->max_pages = $productPaperThicknessData->max_pages;
        $productPaperThickness->price_per_page_bw = $productPaperThicknessData->price_per_page_bw;
        $productPaperThickness->price_per_page_color = $productPaperThicknessData->price_per_page_color;
        $productPaperThickness->is_preselected = $productPaperThicknessData->is_preselected;
        $productPaperThickness->sort = $productPaperThicknessData->sort;
        $productPaperThickness->status = $productPaperThicknessData->status;

        $productPaperThickness->save();

        return $productPaperThickness->refresh();
    }
}

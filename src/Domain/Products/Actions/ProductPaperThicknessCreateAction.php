<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\Models\ProductPaperThickness;

class ProductPaperThicknessCreateAction
{
    public function __invoke(ProductPaperThicknessData $productPaperThicknessData): ProductPaperThickness
    {
        app(PreSelectedFieldResetAction::class)(ProductPaperThickness::newModelInstance(['product_id' => $productPaperThicknessData->product_id]), $productPaperThicknessData->is_preselected, 'product_id');

        return ProductPaperThickness::create([
            'product_id' => $productPaperThicknessData->product_id,
            'title' => $productPaperThicknessData->title,
            'tooltip' => $productPaperThicknessData->tooltip,
            'max_pages' => $productPaperThicknessData->max_pages,
            'price_per_page_bw' => $productPaperThicknessData->price_per_page_bw,
            'price_per_page_color' => $productPaperThicknessData->price_per_page_color,
            'is_preselected' => $productPaperThicknessData->is_preselected,
            'sort' => $productPaperThicknessData->sort,
            'status' => $productPaperThicknessData->status,
        ]);
    }
}

<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\Models\ProductFormat;

class ProductFormatUpdateAction
{
    public function __invoke(ProductFormat $productFormat, ProductFormatData $productFormatData): ProductFormat
    {
        app(PreSelectedFieldResetAction::class)($productFormat, $productFormatData->is_preselected, 'product_id');

        $productFormat->product_id = $productFormatData->product_id;
        $productFormat->title = $productFormatData->title;
        $productFormat->is_preselected = $productFormatData->is_preselected;
        $productFormat->sort = $productFormatData->sort;
        $productFormat->status = $productFormatData->status;

        $productFormat->save();

        return $productFormat->refresh();
    }
}

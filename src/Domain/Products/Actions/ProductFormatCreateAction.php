<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\Models\ProductFormat;

class ProductFormatCreateAction
{
    public function __invoke(ProductFormatData $productFormatData): ProductFormat
    {
        app(PreSelectedFieldResetAction::class)(ProductFormat::newModelInstance(['product_id' => $productFormatData->product_id]), $productFormatData->is_preselected, 'product_id');

        return ProductFormat::create([
            'product_id' => $productFormatData->product_id,
            'title' => $productFormatData->title,
            'is_preselected' => $productFormatData->is_preselected,
            'sort' => $productFormatData->sort,
            'status' => $productFormatData->status,
        ]);
    }
}

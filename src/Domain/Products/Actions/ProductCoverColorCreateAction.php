<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\Models\ProductCoverColor;

class ProductCoverColorCreateAction
{
    public function __invoke(ProductCoverColorData $productCoverColorData): ProductCoverColor
    {
        app(PreSelectedFieldResetAction::class)(ProductCoverColor::newModelInstance(['product_id' => $productCoverColorData->product_id]), $productCoverColorData->is_preselected, 'product_id');

        return ProductCoverColor::create([
            'product_id' => $productCoverColorData->product_id,
            'title' => $productCoverColorData->title,
            'is_preselected' => $productCoverColorData->is_preselected,
            'sort' => $productCoverColorData->sort,
            'status' => $productCoverColorData->status,
        ]);
    }
}

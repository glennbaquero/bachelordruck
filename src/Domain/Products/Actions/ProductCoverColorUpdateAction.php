<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\Models\ProductCoverColor;

class ProductCoverColorUpdateAction
{
    public function __invoke(ProductCoverColor $productCoverColor, ProductCoverColorData $productCoverColorData): ProductCoverColor
    {
        app(PreSelectedFieldResetAction::class)($productCoverColor, $productCoverColorData->is_preselected, 'product_id');

        $productCoverColor->product_id = $productCoverColorData->product_id;
        $productCoverColor->title = $productCoverColorData->title;
        $productCoverColor->is_preselected = $productCoverColorData->is_preselected;
        $productCoverColor->sort = $productCoverColorData->sort;
        $productCoverColor->status = $productCoverColorData->status;

        $productCoverColor->save();

        return $productCoverColor->refresh();
    }
}

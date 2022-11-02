<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\Models\ProductBackCover;

class ProductBackCoverUpdateAction
{
    public function __invoke(ProductBackCover $productBackCover, ProductBackCoverData $productBackCoverData): ProductBackCover
    {
        app(PreSelectedFieldResetAction::class)($productBackCover, $productBackCoverData->is_preselected);

        $productBackCover->title = $productBackCoverData->title;
        $productBackCover->color = $productBackCoverData->color;
        $productBackCover->is_preselected = $productBackCoverData->is_preselected;
        $productBackCover->sort = $productBackCoverData->sort;
        $productBackCover->status = $productBackCoverData->status;

        $productBackCover->save();

        return $productBackCover->refresh();
    }
}

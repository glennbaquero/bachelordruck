<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\Models\ProductBackCover;

class ProductBackCoverCreateAction
{
    public function __invoke(ProductBackCoverData $productBackCoverData): ProductBackCover
    {
        app(PreSelectedFieldResetAction::class)(ProductBackCover::newModelInstance(), $productBackCoverData->is_preselected);

        return ProductBackCover::create([
            'title' => $productBackCoverData->title,
            'color' => $productBackCoverData->color,
            'is_preselected' => $productBackCoverData->is_preselected,
            'sort' => $productBackCoverData->sort,
            'status' => $productBackCoverData->status,
        ]);
    }
}

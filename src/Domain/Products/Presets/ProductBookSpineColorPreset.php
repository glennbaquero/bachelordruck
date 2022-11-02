<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookSpineColor;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductBookSpineColorPreset
{
    use Sortable;

    public function __invoke(ProductBookSpineColor $productBookSpineColor = new ProductBookSpineColor(), ?Model $parentModel = null): Model
    {
        $productBookSpineColor->is_preselected = false;
        $productBookSpineColor->status = StatusEnum::DRAFT;

        $productBookSpineColor->sort = $this->nextSortValue($productBookSpineColor, $parentModel);

        return $productBookSpineColor;
    }
}

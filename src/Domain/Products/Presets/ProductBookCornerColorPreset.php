<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookCornerColor;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductBookCornerColorPreset
{
    use Sortable;

    public function __invoke(ProductBookCornerColor $productBookCornerColor = new ProductBookCornerColor(), ?Model $parentModel = null): Model
    {
        $productBookCornerColor->is_preselected = false;
        $productBookCornerColor->status = StatusEnum::DRAFT;

        $productBookCornerColor->sort = $this->nextSortValue($productBookCornerColor, $parentModel);

        return $productBookCornerColor;
    }
}

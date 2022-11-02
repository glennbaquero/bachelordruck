<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductRibbonColor;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductRibbonColorPreset
{
    use Sortable;

    public function __invoke(ProductRibbonColor $productRibbonColor = new ProductRibbonColor(), ?Model $parentModel = null): Model
    {
        $productRibbonColor->is_preselected = false;
        $productRibbonColor->status = StatusEnum::DRAFT;

        $productRibbonColor->sort = $this->nextSortValue($productRibbonColor, $parentModel);

        return $productRibbonColor;
    }
}

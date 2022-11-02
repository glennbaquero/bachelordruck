<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverImprintColor;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductCoverImprintColorPreset
{
    use Sortable;

    public function __invoke(ProductCoverImprintColor $productCoverImprintColor = new ProductCoverImprintColor(), ?Model $parentModel = null): Model
    {
        $productCoverImprintColor->is_preselected = false;
        $productCoverImprintColor->status = StatusEnum::DRAFT;

        $productCoverImprintColor->sort = $this->nextSortValue($productCoverImprintColor, $parentModel);

        return $productCoverImprintColor;
    }
}

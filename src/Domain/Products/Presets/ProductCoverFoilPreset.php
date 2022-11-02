<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverFoil;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductCoverFoilPreset
{
    use Sortable;

    public function __invoke(ProductCoverFoil $productCoverFoil = new ProductCoverFoil(), ?Model $parentModel = null): Model
    {
        $productCoverFoil->is_preselected = false;
        $productCoverFoil->status = StatusEnum::DRAFT;

        $productCoverFoil->sort = $this->nextSortValue($productCoverFoil, $parentModel);

        return $productCoverFoil;
    }
}

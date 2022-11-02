<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductFormat;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductFormatPreset
{
    use Sortable;

    public function __invoke(ProductFormat $productFormat = new ProductFormat(), ?Model $parentModel = null): Model
    {
        $productFormat->is_preselected = false;
        $productFormat->status = StatusEnum::DRAFT;

        $productFormat->sort = $this->nextSortValue($productFormat, $parentModel);

        return $productFormat;
    }
}

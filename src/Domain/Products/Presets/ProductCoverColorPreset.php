<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverColor;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductCoverColorPreset
{
    use Sortable;

    public function __invoke(ProductCoverColor $productCoverColor = new ProductCoverColor(), ?Model $parentModel = null): Model
    {
        $productCoverColor->is_preselected = false;
        $productCoverColor->status = StatusEnum::DRAFT;

        $productCoverColor->sort = $this->nextSortValue($productCoverColor, $parentModel);

        return $productCoverColor;
    }
}

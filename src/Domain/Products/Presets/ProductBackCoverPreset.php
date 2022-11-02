<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBackCover;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductBackCoverPreset
{
    use Sortable;

    public function __invoke(ProductBackCover $productBackCover = new ProductBackCover(), ?Model $parentModel = null): Model
    {
        $productBackCover->is_preselected = false;
        $productBackCover->status = StatusEnum::DRAFT;

        $productBackCover->sort = $this->nextSortValue($productBackCover, $parentModel);

        return $productBackCover;
    }
}

<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductPaperThickness;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class ProductPaperThicknessPreset
{
    use Sortable;

    public function __invoke(ProductPaperThickness $productPaperThickness = new ProductPaperThickness(), ?Model $parentModel = null): Model
    {
        $productPaperThickness->price_per_page_bw = 0;
        $productPaperThickness->price_per_page_color = 0;
        $productPaperThickness->is_preselected = false;
        $productPaperThickness->status = StatusEnum::DRAFT;

        $productPaperThickness->sort = $this->nextSortValue($productPaperThickness, $parentModel);

        return $productPaperThickness;
    }
}

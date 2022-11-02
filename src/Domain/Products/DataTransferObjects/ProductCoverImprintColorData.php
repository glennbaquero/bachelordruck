<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverImprintColor;
use Spatie\DataTransferObject\DataTransferObject;

class ProductCoverImprintColorData extends DataTransferObject
{
    public string $title;

    public string $color;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    public static function fromModel(ProductCoverImprintColor $productCoverImprintColor): ProductCoverImprintColorData
    {
        return new self(
            title: $productCoverImprintColor->title,
            color: $productCoverImprintColor->color,
            is_preselected: $productCoverImprintColor->is_preselected,
            sort: $productCoverImprintColor->sort,
            status: $productCoverImprintColor->status,
        );
    }
}

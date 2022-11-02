<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductFormat;
use Spatie\DataTransferObject\DataTransferObject;

class ProductFormatData extends DataTransferObject
{
    public int $product_id;

    public string $title;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    public static function fromModel(ProductFormat $productFormat): ProductFormatData
    {
        return new self(
            product_id: $productFormat->product_id,
            title: $productFormat->title,
            is_preselected: $productFormat->is_preselected,
            sort: $productFormat->sort,
            status: $productFormat->status,
        );
    }
}

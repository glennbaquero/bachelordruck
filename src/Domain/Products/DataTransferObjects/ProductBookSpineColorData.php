<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookSpineColor;
use Spatie\DataTransferObject\DataTransferObject;

class ProductBookSpineColorData extends DataTransferObject
{
    public int $product_id;

    public string $title;

    public string $color;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        int $product_id,
        string $title,
        string $color,
        bool $is_preselected = false,
        int $sort = 5,
        StatusEnum $status = StatusEnum::DRAFT,
    ): ProductBookSpineColorData {
        return new self(get_defined_vars());
    }

    public static function fromModel(ProductBookSpineColor $productBookSpineColor): ProductBookSpineColorData
    {
        return new self(
            product_id: $productBookSpineColor->product_id,
            title: $productBookSpineColor->title,
            color: $productBookSpineColor->color,
            is_preselected: $productBookSpineColor->is_preselected,
            sort: $productBookSpineColor->sort,
            status: $productBookSpineColor->status,
        );
    }
}

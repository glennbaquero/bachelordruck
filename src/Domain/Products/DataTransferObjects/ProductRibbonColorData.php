<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductRibbonColor;
use Spatie\DataTransferObject\DataTransferObject;

class ProductRibbonColorData extends DataTransferObject
{
    public string $title;

    public string $color;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $title,
        string $color,
        bool $is_preselected = false,
        int $sort = 5,
        StatusEnum $status = StatusEnum::DRAFT,
    ): ProductRibbonColorData {
        return new self(get_defined_vars());
    }

    public static function fromModel(ProductRibbonColor $productRibbonColor): ProductRibbonColorData
    {
        return new self(
            title: $productRibbonColor->title,
            color: $productRibbonColor->color,
            is_preselected: $productRibbonColor->is_preselected,
            sort: $productRibbonColor->sort,
            status: $productRibbonColor->status,
        );
    }
}

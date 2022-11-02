<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookCornerColor;
use Spatie\DataTransferObject\DataTransferObject;

class ProductBookCornerColorData extends DataTransferObject
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
    ): ProductBookCornerColorData {
        return new self(get_defined_vars());
    }

    public static function fromModel(ProductBookCornerColor $productBookCornerColor): ProductBookCornerColorData
    {
        return new self(
            title: $productBookCornerColor->title,
            color: $productBookCornerColor->color,
            is_preselected: $productBookCornerColor->is_preselected,
            sort: $productBookCornerColor->sort,
            status: $productBookCornerColor->status,
        );
    }
}

<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBackCover;
use Spatie\DataTransferObject\DataTransferObject;

class ProductBackCoverData extends DataTransferObject
{
    public string     $title;

    public string     $color;

    public bool       $is_preselected;

    public int        $sort;

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
    ): ProductBackCoverData {
        return new self(get_defined_vars());
    }

    public static function fromModel(ProductBackCover $productBackCover): ProductBackCoverData
    {
        return new self(
            title:          $productBackCover->title,
            color:          $productBackCover->color,
            is_preselected: $productBackCover->is_preselected,
            sort:           $productBackCover->sort,
            status:         $productBackCover->status,
        );
    }
}

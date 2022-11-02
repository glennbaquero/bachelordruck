<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverFoil;
use Spatie\DataTransferObject\DataTransferObject;

class ProductCoverFoilData extends DataTransferObject
{
    public string $title;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $title,
        bool $is_preselected = false,
        int $sort = 5,
        StatusEnum $status = StatusEnum::DRAFT,
    ): ProductCoverFoilData {
        return new self(get_defined_vars());
    }

    public static function fromModel(ProductCoverFoil $productCoverFoil): ProductCoverFoilData
    {
        return new self(
            title: $productCoverFoil->title,
            is_preselected: $productCoverFoil->is_preselected,
            sort: $productCoverFoil->sort,
            status: $productCoverFoil->status,
        );
    }
}

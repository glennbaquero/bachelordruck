<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverColor;
use Spatie\DataTransferObject\DataTransferObject;

class ProductCoverColorData extends DataTransferObject
{
    public int $product_id;

    public string $title;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }

    public static function fromModel(ProductCoverColor $productCoverColor): ProductCoverColorData
    {
        return new self(
            product_id: $productCoverColor->product_id,
            title: $productCoverColor->title,
            is_preselected: $productCoverColor->is_preselected,
            sort: $productCoverColor->sort,
            status: $productCoverColor->status,
        );
    }
}

<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductPaperThickness;
use Spatie\DataTransferObject\DataTransferObject;

class ProductPaperThicknessData extends DataTransferObject
{
    public int $product_id;

    public string $title;

    public string $tooltip;

    public ?int $max_pages;

    public float $price_per_page_bw;

    public float $price_per_page_color;

    public bool $is_preselected;

    public int $sort;

    public StatusEnum $status;

    public static function fromModel(ProductPaperThickness $productPaperThickness): ProductPaperThicknessData
    {
        return new self(
            product_id: $productPaperThickness->product_id,
            title: $productPaperThickness->title,
            tooltip: $productPaperThickness->tooltip,
            max_pages: $productPaperThickness->max_pages ?? null,
            price_per_page_bw: $productPaperThickness->price_per_page_bw,
            price_per_page_color: $productPaperThickness->price_per_page_color,
            is_preselected: $productPaperThickness->is_preselected,
            sort: $productPaperThickness->sort,
            status: $productPaperThickness->status,
        );
    }
}

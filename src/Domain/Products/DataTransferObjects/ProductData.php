<?php

namespace Domain\Products\DataTransferObjects;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ProductData extends DataTransferObject
{
    public ?string $slug = null;

    public string $title;

    public string $tooltip;

    public string $description;

    public float $price;

    public bool $has_cover_color;

    public bool $has_cover_imprint_color;

    public bool $has_cover_foil;

    public bool $has_back_cover;

    public bool $has_book_spine_label;

    public float $book_spine_label_surcharge;

    public bool $has_book_corners;

    public float $book_corners_surcharge;

    public bool $has_ribbon;

    public float $ribbon_surcharge;

    public int $sort;

    public StatusEnum $status;

    public static function fromModel(Product $product): ProductData
    {
        return new self(
            slug: $product->slug,
            title: $product->title,
            tooltip: $product->tooltip,
            description: $product->description,
            price: $product->price,
            has_cover_color: $product->has_cover_color,
            has_cover_imprint_color: $product->has_cover_imprint_color,
            has_cover_foil: $product->has_cover_foil,
            has_back_cover: $product->has_back_cover,
            has_book_spine_label: $product->has_book_spine_label,
            book_spine_label_surcharge: $product->book_spine_label_surcharge,
            has_book_corners: $product->has_book_corners,
            book_corners_surcharge: $product->book_corners_surcharge,
            has_ribbon: $product->has_ribbon,
            ribbon_surcharge: $product->ribbon_surcharge,
            sort: $product->sort,
            status: $product->status,
        );
    }
}

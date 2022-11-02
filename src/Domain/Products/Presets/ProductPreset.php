<?php

namespace Domain\Products\Presets;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductPreset
{
    public function __invoke(Product $product = new Product()): Model
    {
        $product->price = 0;
        $product->has_cover_color = false;
        $product->has_cover_imprint_color = false;
        $product->has_cover_foil = false;
        $product->has_back_cover = false;
        $product->has_book_spine_label = false;
        $product->book_spine_label_surcharge = 0;
        $product->has_book_corners = false;
        $product->book_corners_surcharge = 0;
        $product->has_ribbon = false;
        $product->ribbon_surcharge = 0;
        $product->status = StatusEnum::DRAFT;

        return $product;
    }
}

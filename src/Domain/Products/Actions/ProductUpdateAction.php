<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\Models\Product;
use Illuminate\Support\Str;

class ProductUpdateAction
{
    public function __invoke(Product $product, ProductData $productData): Product
    {
        $product->slug = $productData->slug ?? Str::slug($productData->title);
        $product->title = $productData->title;
        $product->tooltip = $productData->tooltip;
        $product->description = $productData->description;
        $product->price = $productData->price;
        $product->has_cover_color = $productData->has_cover_color;
        $product->has_cover_imprint_color = $productData->has_cover_imprint_color;
        $product->has_cover_foil = $productData->has_cover_foil;
        $product->has_back_cover = $productData->has_back_cover;
        $product->has_book_spine_label = $productData->has_book_spine_label;
        $product->book_spine_label_surcharge = $productData->book_spine_label_surcharge;
        $product->has_book_corners = $productData->has_book_corners;
        $product->book_corners_surcharge = $productData->book_corners_surcharge;
        $product->has_ribbon = $productData->has_ribbon;
        $product->ribbon_surcharge = $productData->ribbon_surcharge;
        $product->sort = $productData->sort;
        $product->status = $productData->status;

        $product->save();

        return $product->refresh();
    }
}

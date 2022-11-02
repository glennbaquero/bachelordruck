<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\Models\Product;
use Illuminate\Support\Str;

class ProductCreateAction
{
    public function __invoke(ProductData $productData): Product
    {
        return Product::create([
            'slug' => $productData->slug ?? Str::slug($productData->title, '-', config('app.locale')),
            'title' => $productData->title,
            'tooltip' => $productData->tooltip,
            'description' => $productData->description,
            'price' => $productData->price,
            'has_cover_color' => $productData->has_cover_color,
            'has_cover_imprint_color' => $productData->has_cover_imprint_color,
            'has_cover_foil' => $productData->has_cover_foil,
            'has_back_cover' => $productData->has_back_cover,
            'has_book_spine_label' => $productData->has_book_spine_label,
            'book_spine_label_surcharge' => $productData->book_spine_label_surcharge,
            'has_book_corners' => $productData->has_book_corners,
            'book_corners_surcharge' => $productData->book_corners_surcharge,
            'has_ribbon' => $productData->has_ribbon,
            'ribbon_surcharge' => $productData->ribbon_surcharge,
            'sort' => $productData->sort,
            'status' => $productData->status,
        ]);
    }
}

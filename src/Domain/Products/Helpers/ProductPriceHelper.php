<?php

namespace Domain\Products\Helpers;

use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Products\Models\Product;

class ProductPriceHelper
{
    public static function compute(Product $product, ProductConfigurationData $productConfigurationData): float|int
    {
        $price = $product->price;

        // Book Spine Label
        if ($productConfigurationData->has_book_spine_label) {
            $price += $productConfigurationData->book_spine_label_surcharge;
        }

        // Book Corners
        if ($productConfigurationData->has_book_corners) {
            $price += $productConfigurationData->book_corners_surcharge;
        }

        // Ribbon
        if ($productConfigurationData->has_ribbon) {
            $price += $productConfigurationData->book_ribbon_surcharge;
        }

        // Paper Thickness
        $numberOfBlackAndWhitePages = $productConfigurationData->total_number_of_pages - $productConfigurationData->number_of_colored_pages;
        $price += $numberOfBlackAndWhitePages * $productConfigurationData->price_per_page_bw;
        $price += $productConfigurationData->number_of_colored_pages * $productConfigurationData->price_per_page_color;

        // Additional Services
        $price += collect($productConfigurationData->additional_service_surcharges)->sum();

        return $price;
    }
}

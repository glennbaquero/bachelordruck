<?php

namespace Tests\Feature\Domain\Products;

use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Products\Helpers\ProductPriceHelper;
use Domain\Products\Models\Product;

it('compute the correct cost of the product base on configuration', function () {
    $product = Product::factory()->create([
        'title' => 'Premium Hardcover inkl. Prägedruck',
        'price' => 2800,
    ]);

    $productConfiguration = ProductConfigurationData::create(
        // Cover Color
        product_id: $product->id,
        has_cover_color: true,

        // Book Spine
        has_book_spine_label: true,
        book_spine_label_surcharge: 700,

        // Book Corners
        has_book_corners: true,
        book_corners_surcharge: 200,

        // Ribbon
        has_ribbon: true,
        book_ribbon_surcharge: 200,

        // Paper Thickness
        total_number_of_pages: 100,
        number_of_colored_pages: 50,
        double_sided_printing: false,
        price_per_page_bw: 0.05,
        price_per_page_color: .30,
        additional_services: [
            1,
            2,
            3,
        ],
        additional_service_surcharges: [
            1 => 350,
            2 => 150,
            3 => 150,
        ],
    );

    $cost = ProductPriceHelper::compute($product, $productConfiguration);

    expect($cost)->toBe(4567.5);
});

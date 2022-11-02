<?php

namespace Tests\Feature\Domain\Orders;

use Database\Seeders\AdditionalServiceSeeder;
use Database\Seeders\ProductBackCoverSeeder;
use Database\Seeders\ProductBookCornerColorSeeder;
use Database\Seeders\ProductCoverImprintColorSeeder;
use Database\Seeders\ProductFoilSeeder;
use Database\Seeders\ProductRibbonColorSeeder;
use Database\Seeders\ProductSeeder;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Services\ProductConfigurationService;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Models\ProductRibbonColor;
use function Pest\Laravel\seed;

beforeEach(function () {
    seed([
        ProductSeeder::class, ProductSeeder::class,
        ProductBackCoverSeeder::class,
        ProductBookCornerColorSeeder::class,
        ProductRibbonColorSeeder::class,
        ProductFoilSeeder::class,
        ProductCoverImprintColorSeeder::class,
        AdditionalServiceSeeder::class,
    ]);
});

it('creates a default product configuration array for Premium Hardcover inkl. Prägedruck', function () {

    /** @var Product $product */
    $product = Product::whereTitle('Premium Hardcover inkl. Prägedruck')->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers);

    expect($service->default())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => true,
        'product_cover_color_id' => $product->activeProductCoverColors->firstWhere('is_preselected', 1)->id,
        'product_cover_imprint_color_id' => $productCoverImprintColors->firstWhere('is_preselected', 1)->id,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => $productBookCornerColors->firstWhere('is_preselected', 1)->id,
        'book_corners_surcharge' => $product->book_corners_surcharge,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => $productRibbonColors->firstWhere('is_preselected', 1)->id,
        'book_ribbon_surcharge' => $product->ribbon_surcharge,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 1,
        'number_of_colored_pages' => 0,
        'double_sided_printing' => false,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => [],
        'additional_service_surcharges' => [],
        'text_label_printing_cd' => null,

        // Cover Foil
        'product_cover_foil_id' => null,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => null,
    ]);
});

it('creates a default product configuration array for Premium Hardcover ohne Prägedruck and Softcover mit Prägedruck', function ($productTitle) {

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers);

    expect($service->default())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => true,
        'product_cover_color_id' => $product->activeProductCoverColors->firstWhere('is_preselected', 1)->id,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => $productBookCornerColors->firstWhere('is_preselected', 1)->id,
        'book_corners_surcharge' => $product->book_corners_surcharge,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => $productRibbonColors->firstWhere('is_preselected', 1)->id,
        'book_ribbon_surcharge' => $product->ribbon_surcharge,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 1,
        'number_of_colored_pages' => 0,
        'double_sided_printing' => false,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => [],
        'additional_service_surcharges' => [],
        'text_label_printing_cd' => null,

        // Cover Foil
        'product_cover_foil_id' => null,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => null,
    ]);
})->with([
    'Premium Hardcover ohne Prägedruck',
    'Softcover mit Prägedruck',
]);

it('creates a default product configuration array for Plastik-Spiralbindung and Draht-Spiralbindung', function ($productTitle) {

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers);

    expect($service->default())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => false,
        'product_book_spine_color_id' => null,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => 0.0,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0.0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0.0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 1,
        'number_of_colored_pages' => 0,
        'double_sided_printing' => false,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => [],
        'additional_service_surcharges' => [],
        'text_label_printing_cd' => null,

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    'Plastik-Spiralbindung',
    'Draht-Spiralbindung',
]);

it('creates a default product configuration array for Heißleimbindung and Kaltleimbindung', function ($productTitle) {

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers);

    expect($service->default())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0.0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0.0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 1,
        'number_of_colored_pages' => 0,
        'double_sided_printing' => false,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => [],
        'additional_service_surcharges' => [],
        'text_label_printing_cd' => null,

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    'Heißleimbindung',
    'Kaltleimbindung',
]);

it('overrides default product configuration array of hard cover binding', function ($sourceProductTitle, $productTitle) {

    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();
    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['product_cover_color_id'] = $sourceProduct->activeProductCoverColors->where('title', 'Blau')->first()->id;

    $sourceConfigurationArray['has_ribbon'] = true;
    $sourceConfigurationArray['product_ribbon_color_id'] = $productRibbonColors->first()->id;
    $sourceConfigurationArray['book_ribbon_surcharge'] = 100;

    $sourceConfigurationArray['has_book_corners'] = true;
    $sourceConfigurationArray['product_book_corner_color_id'] = $productBookCornerColors->first()->id;
    $sourceConfigurationArray['book_corners_surcharge'] = 100;

    $sourceConfigurationArray['book_spine_label'] = 'Book Spine Label Test';

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => true,
        'product_cover_color_id' => $product->activeProductCoverColors->where('title', 'Blau')->first()->id,
        'product_cover_imprint_color_id' => $product->has_cover_imprint_color ? $productCoverImprintColors->firstWhere('is_preselected', 1)->id : null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => 'Book Spine Label Test',
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => true,
        'product_book_corner_color_id' => $productBookCornerColors->first()->id,
        'book_corners_surcharge' => $product->book_corners_surcharge,

        // Ribbon
        'has_ribbon' => true,
        'product_ribbon_color_id' => $productRibbonColors->first()->id,
        'book_ribbon_surcharge' => $product->ribbon_surcharge,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => null,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => null,
    ]);
})->with([
    // Source Product to New Product
    ['Premium Hardcover inkl. Prägedruck', 'Premium Hardcover ohne Prägedruck'],
    ['Premium Hardcover inkl. Prägedruck', 'Softcover mit Prägedruck'],
    ['Premium Hardcover ohne Prägedruck', 'Premium Hardcover inkl. Prägedruck'],
    ['Premium Hardcover ohne Prägedruck', 'Softcover mit Prägedruck'],
    ['Softcover mit Prägedruck', 'Premium Hardcover inkl. Prägedruck'],
    ['Softcover mit Prägedruck', 'Premium Hardcover ohne Prägedruck'],
]);

it('overrides default product configuration array of hard cover binding to plastic spiral binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['product_cover_color_id'] = $sourceProduct->activeProductCoverColors->where('title', 'Blau')->first()->id;

    $sourceConfigurationArray['has_ribbon'] = true;
    $sourceConfigurationArray['product_ribbon_color_id'] = $productRibbonColors->first()->id;
    $sourceConfigurationArray['book_ribbon_surcharge'] = 100;

    $sourceConfigurationArray['has_book_corners'] = true;
    $sourceConfigurationArray['product_book_corner_color_id'] = $productBookCornerColors->first()->id;
    $sourceConfigurationArray['book_corners_surcharge'] = 100;

    $sourceConfigurationArray['book_spine_label'] = 'Book Spine Label Test';

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => false,
        'product_book_spine_color_id' => null,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => 0.0,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0.0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0.0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    // Source Product to New Product
    ['Premium Hardcover inkl. Prägedruck', 'Plastik-Spiralbindung'],
    ['Premium Hardcover inkl. Prägedruck', 'Draht-Spiralbindung'],
    ['Premium Hardcover ohne Prägedruck', 'Plastik-Spiralbindung'],
    ['Premium Hardcover ohne Prägedruck', 'Draht-Spiralbindung'],
    ['Softcover mit Prägedruck', 'Plastik-Spiralbindung'],
    ['Softcover mit Prägedruck', 'Draht-Spiralbindung'],
]);

it('overrides default product configuration array of hard cover binding to perfect binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['product_cover_color_id'] = $sourceProduct->activeProductCoverColors->where('title', 'Blau')->first()->id;

    $sourceConfigurationArray['has_ribbon'] = true;
    $sourceConfigurationArray['product_ribbon_color_id'] = $productRibbonColors->first()->id;
    $sourceConfigurationArray['book_ribbon_surcharge'] = 100;

    $sourceConfigurationArray['has_book_corners'] = true;
    $sourceConfigurationArray['product_book_corner_color_id'] = $productBookCornerColors->first()->id;
    $sourceConfigurationArray['book_corners_surcharge'] = 100;

    $sourceConfigurationArray['book_spine_label'] = 'Book Spine Label Test';

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => 'Book Spine Label Test',
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    // Source Product to New Product
    ['Premium Hardcover inkl. Prägedruck', 'Heißleimbindung'],
    ['Premium Hardcover inkl. Prägedruck', 'Kaltleimbindung'],
    ['Premium Hardcover ohne Prägedruck', 'Heißleimbindung'],
    ['Premium Hardcover ohne Prägedruck', 'Kaltleimbindung'],
    ['Softcover mit Prägedruck', 'Heißleimbindung'],
    ['Softcover mit Prägedruck', 'Kaltleimbindung'],
]);

it('overrides default product configuration array of plastic spiral binding to hard cover binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['has_book_spine_label'] = true;
    $sourceConfigurationArray['book_spine_label'] = 'Book Spine Label Test';

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => true,
        'product_cover_color_id' => $product->activeProductCoverColors->firstWhere('is_preselected', 1)->id,
        'product_cover_imprint_color_id' => $product->has_cover_imprint_color ? $productCoverImprintColors->firstWhere('is_preselected', 1)->id : null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => $productBookCornerColors->firstWhere('is_preselected', 1)->id,
        'book_corners_surcharge' => $product->book_corners_surcharge,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => $productRibbonColors->firstWhere('is_preselected', 1)->id,
        'book_ribbon_surcharge' => $product->ribbon_surcharge,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => null,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => null,
    ]);
})->with([
    // Source Product to New Product
    ['Plastik-Spiralbindung', 'Premium Hardcover inkl. Prägedruck'],
    ['Draht-Spiralbindung', 'Premium Hardcover inkl. Prägedruck'],
    ['Plastik-Spiralbindung', 'Premium Hardcover ohne Prägedruck'],
    ['Draht-Spiralbindung', 'Premium Hardcover ohne Prägedruck'],
    ['Plastik-Spiralbindung', 'Softcover mit Prägedruck'],
    ['Draht-Spiralbindung', 'Softcover mit Prägedruck'],
]);

it('overrides default product configuration array of perfect binding to hard cover binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['has_book_spine_label'] = true;
    $sourceConfigurationArray['book_spine_label'] = 'Book Spine Label Test';

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => true,
        'product_cover_color_id' => $product->activeProductCoverColors->firstWhere('is_preselected', 1)->id,
        'product_cover_imprint_color_id' => $product->has_cover_imprint_color ? $productCoverImprintColors->firstWhere('is_preselected', 1)->id : null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => 'Book Spine Label Test',
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => $productBookCornerColors->firstWhere('is_preselected', 1)->id,
        'book_corners_surcharge' => $product->book_corners_surcharge,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => $productRibbonColors->firstWhere('is_preselected', 1)->id,
        'book_ribbon_surcharge' => $product->ribbon_surcharge,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => null,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => null,
    ]);
})->with([
    // Source Product to New Product
    ['Heißleimbindung', 'Premium Hardcover inkl. Prägedruck'],
    ['Kaltleimbindung', 'Premium Hardcover inkl. Prägedruck'],
    ['Heißleimbindung', 'Premium Hardcover ohne Prägedruck'],
    ['Kaltleimbindung', 'Premium Hardcover ohne Prägedruck'],
    ['Heißleimbindung', 'Softcover mit Prägedruck'],
    ['Kaltleimbindung', 'Softcover mit Prägedruck'],
]);

it('overrides default product configuration array of plastic spiral binding to perfect binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => true,
        'product_book_spine_color_id' => $product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => $product->book_spine_label_surcharge,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0.0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0.0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    // Source Product to New Product
    ['Plastik-Spiralbindung', 'Heißleimbindung'],
    ['Draht-Spiralbindung', 'Heißleimbindung'],
    ['Plastik-Spiralbindung', 'Kaltleimbindung'],
    ['Draht-Spiralbindung', 'Kaltleimbindung'],
]);

it('overrides default product configuration array of perfect binding to plastic spiral binding', function ($sourceProductTitle, $productTitle) {
    /** @var Product $sourceProduct */
    $sourceProduct = Product::whereTitle($sourceProductTitle)->first();

    /** @var Product $product */
    $product = Product::whereTitle($productTitle)->first();

    $productCoverImprintColors = ProductCoverImprintColor::query()->sortedActive()->get();
    $productBookCornerColors = ProductBookCornerColor::query()->sortedActive()->get();
    $productRibbonColors = ProductRibbonColor::query()->sortedActive()->get();
    $productCoverFoils = ProductCoverFoil::query()->sortedActive()->get();
    $productBackCovers = ProductBackCover::query()->sortedActive()->get();
    $additionalServices = AdditionalService::query()->sortedActive()->get();

    $sourceConfigurationArray = (new ProductConfigurationService($sourceProduct, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers))
        ->default();

    $sourceConfigurationArray['total_number_of_pages'] = 150;
    $sourceConfigurationArray['number_of_colored_pages'] = 25;
    $sourceConfigurationArray['double_sided_printing'] = true;
    $sourceConfigurationArray['additional_services'] = $additionalServices->pluck('id')->all();
    $sourceConfigurationArray['additional_service_surcharges'] = $additionalServices->pluck('surcharge')->all();
    $sourceConfigurationArray['text_label_printing_cd'] = 'CD Label Test';

    $sourceConfiguration = new ProductConfigurationData($sourceConfigurationArray);

    $service = new ProductConfigurationService($product, $productCoverImprintColors, $productBookCornerColors, $productRibbonColors, $productCoverFoils, $productBackCovers, $sourceProduct, $sourceConfiguration);

    expect($service->override())->toEqual([
        'product_id' => $product->id,
        'has_cover_color' => false,
        'product_cover_color_id' => null,
        'product_cover_imprint_color_id' => null,

        // Book Spine
        'has_book_spine_label' => false,
        'product_book_spine_color_id' => null,
        'book_spine_label' => null,
        'book_spine_label_surcharge' => 0,

        // Book Corners
        'has_book_corners' => false,
        'product_book_corner_color_id' => null,
        'book_corners_surcharge' => 0.0,

        // Ribbon
        'has_ribbon' => false,
        'product_ribbon_color_id' => null,
        'book_ribbon_surcharge' => 0.0,

        // Paper Thickness
        'product_paper_thickness_id' => $product->activeProductPaperThicknesses->firstWhere('is_preselected', 1)->id,
        'total_number_of_pages' => 150,
        'number_of_colored_pages' => 25,
        'double_sided_printing' => true,
        'price_per_page_bw' => 0,
        'price_per_page_color' => 0,
        'additional_services' => $additionalServices->pluck('id')->all(),
        'additional_service_surcharges' => $additionalServices->pluck('surcharge')->all(),
        'text_label_printing_cd' => 'CD Label Test',

        // Cover Foil
        'product_cover_foil_id' => $productCoverFoils->firstWhere('is_preselected', 1)->id,

        // Cover Foil
        'product_format_id' => $product->activeProductFormats->firstWhere('is_preselected', 1)->id,

        // Back Cover
        'product_back_cover_id' => $productBackCovers->firstWhere('is_preselected', 1)->id,
    ]);
})->with([
    // Source Product to New Product
    ['Heißleimbindung', 'Plastik-Spiralbindung'],
    ['Kaltleimbindung', 'Plastik-Spiralbindung'],
    ['Heißleimbindung', 'Draht-Spiralbindung'],
    ['Kaltleimbindung', 'Draht-Spiralbindung'],
]);

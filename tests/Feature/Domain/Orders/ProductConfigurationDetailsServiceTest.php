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
use Domain\Orders\Services\ProductConfigurationDetailsService;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Models\ProductCoverImprintColor;
use Domain\Products\Models\ProductPaperThickness;
use function Pest\Laravel\seed;

test('it creates a product configuration details for hardcover', function () {
    seed([
        ProductSeeder::class, ProductSeeder::class,
        ProductBackCoverSeeder::class,
        ProductBookCornerColorSeeder::class,
        ProductRibbonColorSeeder::class,
        ProductFoilSeeder::class,
        ProductCoverImprintColorSeeder::class,
        AdditionalServiceSeeder::class,
    ]);

    /** @var Product $product */
    $product = Product::with([
        'activeProductPaperThicknesses',
        'activeProductCoverColors.media',
        'activeProductBookSpineColors',
        'activeProductFormats',
    ])
        ->where('title', 'Premium Hardcover inkl. Prägedruck')
        ->first();

    /** @var ProductPaperThickness $paperThickness */
    $paperThickness = $product->activeProductPaperThicknesses->first();
    $coverColor = $product->activeProductCoverColors->first();
    $bookSpine = $product->activeProductBookSpineColors->first();
    $format = $product->activeProductFormats->first();

    /** @var ProductCoverImprintColor $coverImprint */
    $coverImprint = ProductCoverImprintColor::first();

    /** @var ProductBookCornerColor $bookCorner */
    $bookCorner = ProductBookCornerColor::first();

    $additionalServices = AdditionalService::get();

    $productConfigurationData = ProductConfigurationData::create(
        product_id: $product->id,
        has_cover_color: true,
        product_cover_color_id: $coverColor->id,
        product_cover_imprint_color_id: $coverImprint->id,
        has_book_spine_label: true,
        product_book_spine_color_id: $bookSpine->id,
        book_spine_label: 'Book Spine Label',
        book_spine_label_surcharge: $product->book_spine_label_surcharge,
        has_book_corners: true,
        product_book_corner_color_id: $bookCorner->id,
        book_ribbon_surcharge: $product->ribbon_surcharge,
        product_paper_thickness_id: $paperThickness->id,
        total_number_of_pages: 100,
        number_of_colored_pages: 10,
        double_sided_printing: false,
        price_per_page_bw: $paperThickness->price_per_page_bw,
        price_per_page_color: $paperThickness->price_per_page_color,
        additional_services: $additionalServices->pluck('id')->all(),
        text_label_printing_cd: 'Text Label Printing CD',
    );

    $details = ProductConfigurationDetailsService::make($product, 1, $productConfigurationData);

    expect($details)->toEqual([
        ['key' => 'quantity', 'label' => 'Auflage', 'value' => 1],
        ['key' => 'cover_color', 'label' => 'Farbe Prägedruck', 'value' => 'Schwarz'],
        ['key' => 'with_book_spine_label', 'label' => '', 'value' => 'Mit Buchrückenbeschriftung'],
        ['key' => 'book_spine_text', 'label' => 'Text für Buchrückenbeschriftung', 'value' => 'Book Spine Label'],
        ['key' => 'with_book_corners', 'label' => '', 'value' => 'Mit Buchecken'],
        ['key' => 'book_corners_color', 'label' => 'Farbe Buchecken', 'value' => 'Weiß'],
        ['key' => 'paper_thickness', 'label' => 'Papierstärke', 'value' => '80g'],
        ['key' => 'number_of_pages', 'label' => 'Seitenanzahl', 'value' => 100],
        ['key' => 'number_of_colored_pages', 'label' => 'Seitenanzahl davon Farbig', 'value' => 10],
        ['key' => 'additional_services', 'label' => '', 'value' => 'CD brennen mit Labeldruck, Klebehülle für CD, Klebehülle für USB'],
        ['key' => 'text_label_printing_cd', 'label' => 'Text Labeldruck CD', 'value' => 'Text Label Printing CD'],
    ]);
});

test('it creates a product configuration details for spiral binding', function () {
    seed([
        ProductSeeder::class, ProductSeeder::class,
        ProductBackCoverSeeder::class,
        ProductBookCornerColorSeeder::class,
        ProductRibbonColorSeeder::class,
        ProductFoilSeeder::class,
        ProductCoverImprintColorSeeder::class,
        AdditionalServiceSeeder::class,
    ]);

    /** @var Product $product */
    $product = Product::with([
        'activeProductPaperThicknesses',
        'activeProductCoverColors.media',
        'activeProductBookSpineColors',
        'activeProductFormats',
    ])
        ->where('title', 'Plastik-Spiralbindung')
        ->first();

    /** @var ProductPaperThickness $paperThickness */
    $paperThickness = $product->activeProductPaperThicknesses->first();

    $format = $product->activeProductFormats->first();

    /** @var ProductCoverFoil $coverFoil */
    $coverFoil = ProductCoverFoil::first();

    /** @var ProductBackCover $backCover */
    $backCover = ProductBackCover::first();

    $additionalServices = AdditionalService::get();

    $productConfigurationData = ProductConfigurationData::create(
        product_id: $product->id,
        has_cover_color: false,
        product_cover_color_id: null,
        product_cover_imprint_color_id: null,
        has_book_spine_label: false,
        product_book_spine_color_id: null,
        book_spine_label: 'Book Spine Label',
        book_spine_label_surcharge: $product->book_spine_label_surcharge,
        has_book_corners: false,
        product_book_corner_color_id: null,
        book_ribbon_surcharge: $product->ribbon_surcharge,
        product_paper_thickness_id: $paperThickness->id,
        total_number_of_pages: 100,
        number_of_colored_pages: 10,
        double_sided_printing: false,
        price_per_page_bw: $paperThickness->price_per_page_bw,
        price_per_page_color: $paperThickness->price_per_page_color,
        additional_services: $additionalServices->pluck('id')->all(),
        text_label_printing_cd: 'Text Label Printing CD',
        product_cover_foil_id: $coverFoil->id,
        product_format_id: $format->id,
        product_back_cover_id: $backCover->id,
    );

    $details = ProductConfigurationDetailsService::make($product, 1, $productConfigurationData);

    expect($details)->toEqual([
        ['key' => 'quantity', 'label' => 'Auflage', 'value' => 1],
        ['key' => 'cover_foil', 'label' => 'Transparente Folie vorne', 'value' => 'Matt'],
        ['key' => 'back_cover', 'label' => '270g Karton hinten Farbe', 'value' => 'Schwarz'],
        ['key' => 'format', 'label' => 'Format', 'value' => 'A4'],
        ['key' => 'paper_thickness', 'label' => 'Papierstärke', 'value' => '80g'],
        ['key' => 'number_of_pages', 'label' => 'Seitenanzahl', 'value' => 100],
        ['key' => 'number_of_colored_pages', 'label' => 'Seitenanzahl davon Farbig', 'value' => 10],
        ['key' => 'additional_services', 'label' => '', 'value' => 'CD brennen mit Labeldruck, Klebehülle für CD, Klebehülle für USB'],
        ['key' => 'text_label_printing_cd', 'label' => 'Text Labeldruck CD', 'value' => 'Text Label Printing CD'],
    ]);
});

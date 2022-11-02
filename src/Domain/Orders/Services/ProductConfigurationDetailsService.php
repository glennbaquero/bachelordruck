<?php

namespace Domain\Orders\Services;

use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Products\Models\AdditionalService;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBackCover;
use Domain\Products\Models\ProductBookCornerColor;
use Domain\Products\Models\ProductCoverFoil;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Models\ProductPaperThickness;
use Domain\Products\Models\ProductRibbonColor;

class ProductConfigurationDetailsService
{
    public function __construct(
        protected Product $product,
        protected int $quantity,
        protected ProductConfigurationData $productConfigurationData
    ) {
    }

    public static function make(Product $product, int $quantity, ProductConfigurationData $productConfigurationData): array
    {
        return (new static($product, $quantity, $productConfigurationData))->compose();
    }

    public function compose(): array
    {
        $details = [];

        // Quantity
        $details[] = $this->makeArray('quantity', 'Auflage', $this->quantity);

        // Cover Color
        if ($this->product->isHardcoverBinding() && $this->productConfigurationData->has_cover_color) {
            $coverColor = $this->product->activeProductCoverColors
                ->where('id', $this->productConfigurationData->product_cover_color_id)
                ->first();

            $details[] = $this->makeArray('cover_color', 'Farbe Prägedruck', $coverColor->title);
        }

        // Cover Foil*
        if ($this->product->isPerfectBinding() || $this->product->isPlasticSpiralBinding()) {
            /** @var ProductCoverFoil $coverFoil */
            $coverFoil = ProductCoverFoil::where('id', $this->productConfigurationData->product_cover_foil_id)->first();

            $details[] = $this->makeArray('cover_foil', 'Transparente Folie vorne', $coverFoil->title);

            // Back Cover Color*
            /** @var ProductBackCover $backCover */
            $backCover = ProductBackCover::where('id', $this->productConfigurationData->product_back_cover_id)->first();

            $details[] = $this->makeArray('back_cover', '270g Karton hinten Farbe', $backCover->title);

            // Format
            /** @var ProductFormat $format */
            $format = $this->product->activeProductFormats->where('id', $this->productConfigurationData->product_format_id)->first();

            $details[] = $this->makeArray('format', 'Format', $format->title);
        }

        // Spine Label
        if ($this->product->has_book_spine_label) {
            if ($this->productConfigurationData->has_book_spine_label) {
                $details[] = $this->makeArray('with_book_spine_label', '', 'Mit Buchrückenbeschriftung');
                $details[] = $this->makeArray('book_spine_text', 'Text für Buchrückenbeschriftung', $this->productConfigurationData->book_spine_label);
            } else {
                $details[] = $this->makeArray('without_book_spine_label', '', 'Ohne Buchrückenbeschriftung');
            }
        }

        // Extras

        // Book Corners
        if ($this->product->has_book_corners && $this->productConfigurationData->has_book_corners) {
            /** @var ProductBookCornerColor $bookCorner */
            $bookCorner = ProductBookCornerColor::where('id', $this->productConfigurationData->product_book_corner_color_id)->first();

            $details[] = $this->makeArray('with_book_corners', '', 'Mit Buchecken');
            $details[] = $this->makeArray('book_corners_color', 'Farbe Buchecken', $bookCorner->title);
        }

        // Ribbon
        if ($this->product->has_ribbon && $this->productConfigurationData->has_ribbon) {
            /** @var ProductRibbonColor $ribbon */
            $ribbon = ProductRibbonColor::where('id', $this->productConfigurationData->product_ribbon_color_id)->first();

            $details[] = $this->makeArray('with_ribbon', '', 'Mit Leseband');
            $details[] = $this->makeArray('ribbon_color', 'Farbe Leseband', $ribbon->title);
        }

        // Paper Thickness
        /** @var ProductPaperThickness $paperThickness */
        $paperThickness = $this->product->activeProductPaperThicknesses->where('id', $this->productConfigurationData->product_paper_thickness_id)->first();

        $details[] = $this->makeArray('paper_thickness', 'Papierstärke', $paperThickness->title);
        $details[] = $this->makeArray('number_of_pages', 'Seitenanzahl', $this->productConfigurationData->total_number_of_pages);

        if ($this->productConfigurationData->double_sided_printing) {
            $details[] = $this->makeArray('double_sided_printing', '', 'Doppelseitig');
        }

        if ($this->productConfigurationData->number_of_colored_pages > 0) {
            $details[] = $this->makeArray('number_of_colored_pages', 'Seitenanzahl davon Farbig', $this->productConfigurationData->number_of_colored_pages);
        }

        // Additional Services
        if (! empty($this->productConfigurationData->additional_services)) {
            $details[] = $this->makeArray('additional_services', '', AdditionalService::whereIn('id', $this->productConfigurationData->additional_services)->pluck('title')->implode(', '));

            if (! empty($this->productConfigurationData->text_label_printing_cd)) {
                $details[] = $this->makeArray('text_label_printing_cd', 'Text Labeldruck CD', $this->productConfigurationData->text_label_printing_cd);
            }
        }

        return $details;
    }

    protected function makeArray(string $key, string $label, $value): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'value' => $value,
        ];
    }
}

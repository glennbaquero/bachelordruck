<?php

namespace Domain\Orders\Services;

use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBookSpineColor;
use Domain\Products\Models\ProductCoverColor;
use Domain\Products\Models\ProductFormat;
use Domain\Products\Models\ProductPaperThickness;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductConfigurationService
{
    public function __construct(
        protected Product $product,
        protected Collection $productCoverImprintColors,
        protected Collection $productBookCornerColors,
        protected Collection $productRibbonColors,
        protected Collection $productCoverFoils,
        protected Collection $productBackCovers,
        protected ?Product $sourceProduct = null,
        protected ?ProductConfigurationData $sourceConfiguration = null,
    ) {
    }

    public function default(): array
    {
        return [
            // Cover Color
            'product_id' => $this->product->id,
            'has_cover_color' => $this->product->has_cover_color,
            'product_cover_color_id' => $this->productCoverColorId(),
            'product_cover_imprint_color_id' => $this->productCoverImprintColorId(),

            // Book Spine
            'has_book_spine_label' => $this->product->has_book_spine_label,
            'product_book_spine_color_id' => $this->productBookSpineColorId(),
            'book_spine_label' => null,
            'book_spine_label_surcharge' => $this->product->has_book_spine_label ? $this->product->book_spine_label_surcharge : 0,

            // Book Corners
            'has_book_corners' => false,
            'product_book_corner_color_id' => $this->productBookCornerColorId(),
            'book_corners_surcharge' => $this->product->has_book_corners ? $this->product->book_corners_surcharge : 0,

            // Ribbon
            'has_ribbon' => false,
            'product_ribbon_color_id' => $this->productRibbonColorId(),
            'book_ribbon_surcharge' => $this->product->has_ribbon ? $this->product->ribbon_surcharge : 0,

            // Paper Thickness
            'product_paper_thickness_id' => $this->productPaperThicknessId(),
            'total_number_of_pages' => 1,
            'number_of_colored_pages' => 0,
            'double_sided_printing' => false,
            'price_per_page_bw' => 0,
            'price_per_page_color' => 0,
            'additional_services' => [],
            'additional_service_surcharges' => [],
            'text_label_printing_cd' => null,

            // Cover Foil
            'product_cover_foil_id' => $this->productCoverFoilId(),

            // Cover Foil
            'product_format_id' => $this->productFormatId(),

            // Back Cover
            'product_back_cover_id' => $this->productBackCoverId(),
        ];
    }

    public function override()
    {
        $defaultConfiguration = $this->default();

        $this->product->loadMissing([
            'activeProductPaperThicknesses',
            'activeProductCoverColors',
            'activeProductBookSpineColors',
            'activeProductFormats',
        ]);

        $this->sourceProduct->loadMissing([
            'activeProductPaperThicknesses',
            'activeProductCoverColors',
            'activeProductBookSpineColors',
            'activeProductFormats',
        ]);

        $defaultColumnsToOverride = [
            'total_number_of_pages',
            'number_of_colored_pages',
            'double_sided_printing',
            'additional_services',
            'additional_service_surcharges',
            'text_label_printing_cd',
        ];

        // Override the default columns
        foreach ($defaultColumnsToOverride as $column) {
            $defaultConfiguration[$column] = $this->sourceConfiguration->$column;
        }

        // Cover Color
        if ($this->product->has_cover_color && $this->sourceProduct->has_cover_color && $this->sourceConfiguration->has_cover_color) {
            $defaultConfiguration['has_cover_color'] = $this->sourceConfiguration->has_cover_color;

            /** @var ProductCoverColor $sourceCoverColor */
            $sourceCoverColor = $this->sourceProduct->activeProductCoverColors->where('id', $this->sourceConfiguration->product_cover_color_id)->first();

            if ($sourceCoverColor) {
                /** @var ProductCoverColor $productCoverColor */
                $productCoverColor = $this->product->activeProductCoverColors->where('title', $sourceCoverColor->title)->first();

                $defaultConfiguration['product_cover_color_id'] = $productCoverColor?->id;
            }
        }

        // Cover Imprint Color
        if ($this->product->has_cover_imprint_color && $this->sourceProduct->has_cover_imprint_color && ! empty($this->sourceConfiguration->product_cover_imprint_color_id)) {
            $defaultConfiguration['product_cover_imprint_color_id'] = $this->sourceConfiguration->product_cover_imprint_color_id;
        }

        // Book Spine Label
        if ($this->product->has_book_spine_label && $this->sourceProduct->has_book_spine_label && ! empty($this->sourceConfiguration->product_book_spine_color_id)) {
            $defaultConfiguration['has_book_spine_label'] = $this->sourceConfiguration->has_book_spine_label;

            $sourceBookSpineColor = $this->sourceProduct->activeProductBookSpineColors->where('id', $this->sourceConfiguration->product_book_spine_color_id)->first();

            if ($sourceBookSpineColor) {
                /** @var ProductBookSpineColor $productBookSpineColor */
                $productBookSpineColor = $this->product->activeProductBookSpineColors->where('title', $sourceBookSpineColor->title)->first();

                if ($productBookSpineColor) {
                    $defaultConfiguration['product_book_spine_color_id'] = $productBookSpineColor->id;
                } else {
                    $defaultConfiguration['product_book_spine_color_id'] = $this->product->activeProductBookSpineColors->firstWhere('is_preselected', 1)->id;
                }

                $defaultConfiguration['book_spine_label_surcharge'] = $this->product->book_spine_label_surcharge;
                $defaultConfiguration['book_spine_label'] = $this->sourceConfiguration->book_spine_label;
            }
        }

        // Book Corners
        if ($this->product->has_book_corners && $this->sourceProduct->has_book_corners && ! empty($this->sourceConfiguration->product_book_corner_color_id)) {
            $defaultConfiguration['has_book_corners'] = $this->sourceConfiguration->has_book_corners;
            $defaultConfiguration['product_book_corner_color_id'] = $this->sourceConfiguration->product_book_corner_color_id;
            $defaultConfiguration['book_corners_surcharge'] = $this->product->book_corners_surcharge;
        }

        // Ribbon
        if ($this->product->has_ribbon && $this->sourceProduct->has_ribbon && ! empty($this->sourceConfiguration->product_ribbon_color_id)) {
            $defaultConfiguration['has_ribbon'] = $this->sourceConfiguration->has_ribbon;
            $defaultConfiguration['product_ribbon_color_id'] = $this->sourceConfiguration->product_ribbon_color_id;
            $defaultConfiguration['book_ribbon_surcharge'] = $this->product->ribbon_surcharge;
        }

        // Paper Thickness
        $sourcePaperThickness = $this->sourceProduct->activeProductPaperThicknesses->where('id', $this->sourceConfiguration->product_paper_thickness_id)->first();

        if ($sourcePaperThickness) {
            /** @var ProductPaperThickness $productPaperThickness */
            $productPaperThickness = $this->product->activeProductPaperThicknesses->where('title', $sourcePaperThickness->title)->first();

            if ($productPaperThickness) {
                $defaultConfiguration['product_paper_thickness_id'] = $productPaperThickness->id;
            }
        }

        // Cover Foil
        if ($this->product->has_cover_foil && $this->sourceProduct->has_cover_foil && ! empty($this->sourceConfiguration->product_cover_foil_id)) {
            $defaultConfiguration['product_cover_foil_id'] = $this->sourceConfiguration->product_cover_foil_id;
        }

        // Product Format
        $sourceProductFormat = $this->sourceProduct->activeProductFormats->where('id', $this->sourceConfiguration->product_format_id)->first();

        if ($sourceProductFormat) {
            /** @var ProductFormat $productFormat */
            $productFormat = $this->product->activeProductFormats->where('title', $sourceProductFormat->title)->first();

            if ($productFormat) {
                $defaultConfiguration['product_format_id'] = $productFormat->id;
            }
        }

        // Back Cover
        if ($this->product->has_back_cover && $this->sourceProduct->has_back_cover && ! empty($this->sourceConfiguration->product_back_cover_id)) {
            $defaultConfiguration['product_back_cover_id'] = $this->sourceConfiguration->product_back_cover_id;
        }

        return $defaultConfiguration;
    }

    private function preSelectedModel(Collection $models): Model
    {
        return $models->where('is_preselected', 1)->first();
    }

    private function productCoverColorId(): ?int
    {
        if (! $this->product->has_cover_color) {
            return null;
        }

        return $this->preSelectedModel($this->product->activeProductCoverColors)?->id;
    }

    private function productCoverImprintColorId(): ?int
    {
        if (! $this->product->has_cover_imprint_color) {
            return null;
        }

        return $this->preSelectedModel($this->productCoverImprintColors)?->id;
    }

    private function productBookSpineColorId()
    {
        if (! $this->product->has_book_spine_label) {
            return null;
        }

        return $this->preSelectedModel($this->product->activeProductBookSpineColors)?->id;
    }

    private function productBookCornerColorId(): ?int
    {
        if (! $this->product->has_book_corners) {
            return null;
        }

        return $this->preSelectedModel($this->productBookCornerColors)?->id;
    }

    private function productRibbonColorId(): ?int
    {
        if (! $this->product->has_ribbon) {
            return null;
        }

        return $this->preSelectedModel($this->productRibbonColors)?->id;
    }

    private function productPaperThicknessId(): ?int
    {
        return $this->preSelectedModel($this->product->activeProductPaperThicknesses)?->id;
    }

    private function productCoverFoilId(): ?int
    {
        if (! $this->product->has_cover_foil) {
            return null;
        }

        return $this->preSelectedModel($this->productCoverFoils)?->id;
    }

    private function productFormatId(): ?int
    {
        return $this->preSelectedModel($this->product->activeProductFormats)?->id;
    }

    private function productBackCoverId(): ?int
    {
        if (! $this->product->has_back_cover) {
            return null;
        }

        return $this->preSelectedModel($this->productBackCovers)?->id;
    }
}

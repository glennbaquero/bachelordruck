<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductBookSpineColorCreateAction;
use Domain\Products\Actions\ProductCoverColorCreateAction;
use Domain\Products\Actions\ProductCreateAction;
use Domain\Products\Actions\ProductFormatCreateAction;
use Domain\Products\Actions\ProductPaperThicknessCreateAction;
use Domain\Products\DataTransferObjects\ProductBookSpineColorData;
use Domain\Products\DataTransferObjects\ProductCoverColorData;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\DataTransferObjects\ProductFormatData;
use Domain\Products\DataTransferObjects\ProductPaperThicknessData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductCoverColor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Product::count() > 0) {
            return;
        }

        $this->createProduct1();
        $this->createProduct2();
        $this->createProduct3();
        $this->createProduct4();
        $this->createProduct5();
        $this->createProduct6();
        $this->createProduct7();
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties $product->id,'80g','',340,5,30,5
     */
    private function createPaperThickness(int $productId, string $title, string $tooltip, int $maxPages, float $priceperPageBW, float $pricePerPageColor, int $sort): void
    {
        app(ProductPaperThicknessCreateAction::class)(
            new ProductPaperThicknessData(
                product_id:           $productId,
                title:                $title,
                tooltip:              $tooltip,
                max_pages:            $maxPages,
                price_per_page_bw:    $priceperPageBW,
                price_per_page_color: $pricePerPageColor,
                is_preselected:       $title === '100g',
                sort:                 $sort,
                status:               StatusEnum::ACTIVE
            )
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function createCoverColor(int $productId, string $title, int $sort, int $productNumber): void
    {
        $productCoverColor = app(ProductCoverColorCreateAction::class)(
            new ProductCoverColorData(
                product_id:     $productId,
                title:          $title,
                is_preselected: $sort === 5,
                sort:           $sort,
                status:         StatusEnum::ACTIVE
            )
        );

        $extension = match ($productNumber) {
            2 => '.jpg',
            default => '.png',
        };

        $this->addProductCoverColorImage($productCoverColor, $productNumber.'/'.Str::slug($title).$extension);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function createFormat(int $productId, string $title, int $sort): void
    {
        app(ProductFormatCreateAction::class)(
            new ProductFormatData(
                product_id:     $productId,
                title:          $title,
                is_preselected: $sort === 5,
                sort:           $sort,
                status:         StatusEnum::ACTIVE
            )
        );
    }

    private function addProductImage(Product $product, string $imageFilename)
    {
        if (app()->environment('testing')) {
            return;
        }

        $product->addMedia(database_path('seeders/images/products/'.$imageFilename))
            ->preservingOriginal()
            ->toMediaCollection('image');
    }

    private function addProductCoverColorImage(ProductCoverColor $productCoverColor, string $imageFilename)
    {
        if (app()->environment('testing')) {
            return;
        }

        $productCoverColor->addMedia(database_path('seeders/images/product_cover_colors/'.$imageFilename))
            ->preservingOriginal()
            ->toMediaCollection('image');
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function createBookSpineColor(int $productId, string $title, string $color, int $sort): void
    {
        app(ProductBookSpineColorCreateAction::class)(
            new ProductBookSpineColorData(
                product_id:     $productId,
                title:          $title,
                color:          $color,
                is_preselected: $sort === 5,
                sort:           $sort,
                status:         StatusEnum::ACTIVE
            )
        );
    }

    private function createProduct1()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Premium Hardcover inkl. Prägedruck',
                'tooltip' => 'bei 80- und 100g Papier bis 340 Blatt möglich, bei 120g Papier bis 280 Blatt möglich',
                'description' => '',
                'price' => 28,
                'has_cover_color' => true,
                'has_cover_imprint_color' => true,
                'has_cover_foil' => false,
                'has_back_cover' => false,
                'has_book_spine_label' => true,
                'book_spine_label_surcharge' => 7,
                'has_book_corners' => true,
                'book_corners_surcharge' => 2,
                'has_ribbon' => true,
                'ribbon_surcharge' => 2,
                'sort' => 5,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createCoverColor($product->id, 'Schwarz', 5, 1);
        $this->createCoverColor($product->id, 'Blau', 10, 1);
        $this->createCoverColor($product->id, 'Grün', 15, 1);
        $this->createCoverColor($product->id, 'Bordeaux', 20, 1);
        $this->createCoverColor($product->id, 'Grau', 25, 1);
        $this->createPaperThickness($product->id, '80g', '', 340, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 340, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 280, 0.15, 0.40, 15);
        $this->createFormat($product->id, 'A4', 5);

        $this->addProductImage($product, 'hardcover-mit-preagung.png');

        $this->createBookSpineColor($product->id, 'Silber', '#C0C0C0', 5);
        $this->createBookSpineColor($product->id, 'Gold', '#ffd700', 10);
    }

    private function createProduct2()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Premium Hardcover ohne Prägedruck',
                'tooltip' => 'bei 80- und 100g Papier bis 340 Blatt möglich, bei 120g Papier bis 280 Blatt möglich',
                'description' => '',
                'price' => 11,
                'has_cover_color' => true,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => false,
                'has_back_cover' => false,
                'has_book_spine_label' => true,
                'book_spine_label_surcharge' => 7,
                'has_book_corners' => true,
                'book_corners_surcharge' => 2,
                'has_ribbon' => true,
                'ribbon_surcharge' => 2,
                'sort' => 10,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createCoverColor($product->id, 'Schwarz', 5, 2);
        $this->createCoverColor($product->id, 'Blau', 10, 2);
        $this->createCoverColor($product->id, 'Grün', 15, 2);
        $this->createCoverColor($product->id, 'Bordeaux', 20, 2);
        $this->createCoverColor($product->id, 'Grau', 25, 2);
        $this->createPaperThickness($product->id, '80g', '', 340, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 340, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 280, 0.15, 0.40, 15);
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->addProductImage($product, 'hardcover-ohne-praegung.png');

        $this->createBookSpineColor($product->id, 'Silber', '#C0C0C0', 5);
        $this->createBookSpineColor($product->id, 'Gold', '#ffd700', 10);
    }

    private function createProduct3()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Softcover mit Prägedruck',
                'tooltip' => 'bei 80- und 100g Papier bis 340 Blatt möglich, bei 120g Papier bis 280 Blatt möglich',
                'description' => '',
                'price' => 15,
                'has_cover_color' => true,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => false,
                'has_back_cover' => false,
                'has_book_spine_label' => true,
                'book_spine_label_surcharge' => 5,
                'has_book_corners' => true,
                'book_corners_surcharge' => 2,
                'has_ribbon' => true,
                'ribbon_surcharge' => 2,
                'sort' => 15,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createCoverColor($product->id, 'Schwarz', 5, 3);
        $this->createCoverColor($product->id, 'Bordeaux', 10, 3);
        $this->createCoverColor($product->id, 'Blau', 15, 3);
        $this->createPaperThickness($product->id, '80g', '', 340, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 340, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 280, 0.15, 0.40, 15);
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->addProductImage($product, 'softcover-kautschuk-hochglanz.png');

        $this->createBookSpineColor($product->id, 'Silber', '#C0C0C0', 5);
        $this->createBookSpineColor($product->id, 'Gold', '#ffd700', 10);
    }

    private function createProduct4()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Plastik-Spiralbindung',
                'tooltip' => 'bis 500 Seiten möglich',
                'description' => '',
                'price' => 3,
                'has_cover_color' => false,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => true,
                'has_back_cover' => true,
                'has_book_spine_label' => false,
                'book_spine_label_surcharge' => 0,
                'has_book_corners' => false,
                'book_corners_surcharge' => 0,
                'has_ribbon' => false,
                'ribbon_surcharge' => 0,
                'sort' => 20,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->addProductImage($product, 'spiralbindung-druck.png');

        $this->createPaperThickness($product->id, '80g', '', 500, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 500, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 500, 0.15, 0.40, 15);
    }

    private function createProduct5()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Draht-Spiralbindung',
                'tooltip' => 'bis 320 Seiten möglich',
                'description' => '',
                'price' => 4,
                'has_cover_color' => false,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => true,
                'has_back_cover' => true,
                'has_book_spine_label' => false,
                'book_spine_label_surcharge' => 0,
                'has_book_corners' => false,
                'book_corners_surcharge' => 0,
                'has_ribbon' => false,
                'ribbon_surcharge' => 0,
                'sort' => 25,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->addProductImage($product, 'drahtspiralbindung.png');

        $this->createPaperThickness($product->id, '80g', '', 320, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 320, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 320, 0.15, 0.40, 15);
    }

    private function createProduct6()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Heißleimbindung',
                'tooltip' => 'bis 340 Seiten möglich',
                'description' => '',
                'price' => 5,
                'has_cover_color' => false,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => true,
                'has_back_cover' => true,
                'has_book_spine_label' => true,
                'book_spine_label_surcharge' => 5,
                'has_book_corners' => false,
                'book_corners_surcharge' => 0,
                'has_ribbon' => false,
                'ribbon_surcharge' => 0,
                'sort' => 30,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->addProductImage($product, 'heissleimbindung-druck.png');

        $this->createBookSpineColor($product->id, 'Weiß', '#bcafa6', 5);
        $this->createPaperThickness($product->id, '80g', '', 340, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 340, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 340, 0.15, 0.40, 15);
    }

    private function createProduct7()
    {
        $product = app(ProductCreateAction::class)(
            new ProductData([
                'title' => 'Kaltleimbindung',
                'tooltip' => 'ab 340 Seiten & Dauer 24 Stunden',
                'description' => '',
                'price' => 10,
                'has_cover_color' => false,
                'has_cover_imprint_color' => false,
                'has_cover_foil' => true,
                'has_back_cover' => true,
                'has_book_spine_label' => true,
                'book_spine_label_surcharge' => 5,
                'has_book_corners' => false,
                'book_corners_surcharge' => 0,
                'has_ribbon' => false,
                'ribbon_surcharge' => 0,
                'sort' => 35,
                'status' => StatusEnum::ACTIVE,
            ])
        );
        $this->createFormat($product->id, 'A4', 5);
        $this->createFormat($product->id, 'A5', 10);

        $this->createPaperThickness($product->id, '80g', '', 340, 0.05, 0.30, 5);
        $this->createPaperThickness($product->id, '100g', '', 340, 0.10, 0.35, 10);
        $this->createPaperThickness($product->id, '120g', '', 340, 0.15, 0.40, 15);
        $this->createBookSpineColor($product->id, 'Weiß', '#bcafa6', 5);
        $this->addProductImage($product, 'kaltleimbindung.png');
    }
}

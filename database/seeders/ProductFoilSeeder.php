<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductCoverFoilCreateAction;
use Domain\Products\DataTransferObjects\ProductCoverFoilData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverFoil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductFoilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductCoverFoil::count() > 0) {
            return;
        }

        $sort = 5;
        $productCoverFoil = app(ProductCoverFoilCreateAction::class)(ProductCoverFoilData::create(title: 'Matt', is_preselected: $sort === 5, sort:$sort, status: StatusEnum::ACTIVE));
        $this->addCoverFoilImage($productCoverFoil, Str::slug($productCoverFoil->title).'.jpg');

        $sort += 5;
        $productCoverFoil = app(ProductCoverFoilCreateAction::class)(ProductCoverFoilData::create(title: 'Glänzend', is_preselected: $sort === 5, sort:$sort, status: StatusEnum::ACTIVE));
        $this->addCoverFoilImage($productCoverFoil, Str::slug($productCoverFoil->title).'.jpg');
    }

    private function addCoverFoilImage(ProductCoverFoil $productCoverFoil, string $imageFilename): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $productCoverFoil->addMedia(database_path('seeders/images/product_cover_foils/'.$imageFilename))
            ->preservingOriginal()
            ->toMediaCollection('image');
    }
}

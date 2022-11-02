<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductCoverImprintColorCreateAction;
use Domain\Products\DataTransferObjects\ProductCoverImprintColorData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverImprintColor;
use Illuminate\Database\Seeder;

class ProductCoverImprintColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductCoverImprintColor::count() > 0) {
            return;
        }

        $sort = 5;
        app(ProductCoverImprintColorCreateAction::class)(new ProductCoverImprintColorData(title: 'Silber', color:'#C0C0C0', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE));
        $sort += 5;
        app(ProductCoverImprintColorCreateAction::class)(new ProductCoverImprintColorData(title: 'Gold', color:'#ffd700', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE));
    }
}

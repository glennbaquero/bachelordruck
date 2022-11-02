<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductRibbonColorCreateAction;
use Domain\Products\DataTransferObjects\ProductRibbonColorData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductRibbonColor;
use Illuminate\Database\Seeder;

class ProductRibbonColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductRibbonColor::count() > 0) {
            return;
        }

        $sort = 5;

        app(ProductRibbonColorCreateAction::class)(
            new ProductRibbonColorData(title: 'Schwarz', color: '#000000', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        app(ProductRibbonColorCreateAction::class)(
            new ProductRibbonColorData(title: 'Silber', color: '#C0C0C0', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        app(ProductRibbonColorCreateAction::class)(
            new ProductRibbonColorData(title: 'Gold', color: '#ffd700', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
    }
}

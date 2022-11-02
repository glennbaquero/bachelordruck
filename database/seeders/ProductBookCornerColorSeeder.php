<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductBookCornerColorCreateAction;
use Domain\Products\DataTransferObjects\ProductBookCornerColorData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBookCornerColor;
use Illuminate\Database\Seeder;

class ProductBookCornerColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductBookCornerColor::count() > 0) {
            return;
        }

        $sort = 5;

        app(ProductBookCornerColorCreateAction::class)(
            new ProductBookCornerColorData(title: 'Weiß', color: '#bcafa6', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        app(ProductBookCornerColorCreateAction::class)(
            new ProductBookCornerColorData(title: 'Silber', color: '#C0C0C0', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        app(ProductBookCornerColorCreateAction::class)(
            new ProductBookCornerColorData(title: 'Gold', color: '#ffd700', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
    }
}

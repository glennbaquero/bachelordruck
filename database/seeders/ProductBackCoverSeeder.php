<?php

namespace Database\Seeders;

use Domain\Products\Actions\ProductBackCoverCreateAction;
use Domain\Products\DataTransferObjects\ProductBackCoverData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBackCover;
use Illuminate\Database\Seeder;

class ProductBackCoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductBackCover::count() > 0) {
            return;
        }

        $productBackCoverCreateAction = app(ProductBackCoverCreateAction::class);
        $sort = 5;

        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Schwarz', color:'#000000', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;

        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Grau', color:'#918a86', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Hellblau', color:'#0199be', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Dunkelblau', color:'#3d678e', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Rot', color:'#ff2700', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Bordeaux', color:'#99262b', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Grün', color:'#635f1e', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
        $productBackCoverCreateAction(
            ProductBackCoverData::create(
                title: 'Weiß', color:'#bcafa6', is_preselected: $sort === 5, sort: $sort, status: StatusEnum::ACTIVE
            )
        );
        $sort += 5;
    }
}

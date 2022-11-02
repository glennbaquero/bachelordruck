<?php

namespace Database\Seeders;

use Domain\Products\Actions\AdditionalServiceCreateAction;
use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\AdditionalService;
use Illuminate\Database\Seeder;

class AdditionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (AdditionalService::count() > 0) {
            return;
        }

        app(AdditionalServiceCreateAction::class)(AdditionalServiceData::create(title: 'CD brennen mit Labeldruck', tooltip: '', surcharge: 3.5, sort: 5, status: StatusEnum::ACTIVE));
        app(AdditionalServiceCreateAction::class)(AdditionalServiceData::create(title: 'Klebehülle für CD', tooltip: '', surcharge: 1.5, sort: 10, status: StatusEnum::ACTIVE));
        app(AdditionalServiceCreateAction::class)(AdditionalServiceData::create(title: 'Klebehülle für USB', tooltip: '', surcharge: 1.5, sort: 15, status: StatusEnum::ACTIVE));
    }
}

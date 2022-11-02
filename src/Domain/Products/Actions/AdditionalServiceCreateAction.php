<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\Models\AdditionalService;

class AdditionalServiceCreateAction
{
    public function __invoke(AdditionalServiceData $additionalServiceData): AdditionalService
    {
        return AdditionalService::create([
            'title' => $additionalServiceData->title,
            'tooltip' => $additionalServiceData->tooltip,
            'surcharge' => $additionalServiceData->surcharge,
            'sort' => $additionalServiceData->sort,
            'status' => $additionalServiceData->status,
        ]);
    }
}

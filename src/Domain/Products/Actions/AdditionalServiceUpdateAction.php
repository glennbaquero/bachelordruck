<?php

namespace Domain\Products\Actions;

use Domain\Products\DataTransferObjects\AdditionalServiceData;
use Domain\Products\Models\AdditionalService;

class AdditionalServiceUpdateAction
{
    public function __invoke(AdditionalService $additionalService, AdditionalServiceData $additionalServiceData): AdditionalService
    {
        $additionalService->title = $additionalServiceData->title;
        $additionalService->tooltip = $additionalServiceData->tooltip;
        $additionalService->surcharge = $additionalServiceData->surcharge;
        $additionalService->sort = $additionalServiceData->sort;
        $additionalService->status = $additionalServiceData->status;

        $additionalService->save();

        return $additionalService->refresh();
    }
}

<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\AdditionalService;

class AdditionalServiceDeleteAction
{
    public function __invoke(AdditionalService $additionalService): void
    {
        $additionalService->delete();
    }
}

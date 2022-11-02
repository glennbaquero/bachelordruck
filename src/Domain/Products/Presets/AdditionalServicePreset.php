<?php

namespace Domain\Products\Presets;

use Domain\Products\Models\AdditionalService;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Sortable;

class AdditionalServicePreset
{
    use Sortable;

    public function __invoke(AdditionalService $additionalService = new AdditionalService(), ?Model $parentModel = null): Model
    {
        $additionalService->sort = $this->nextSortValue($additionalService, $parentModel);

        return $additionalService;
    }
}

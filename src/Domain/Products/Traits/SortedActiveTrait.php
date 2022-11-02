<?php

namespace Domain\Products\Traits;

use Domain\Products\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

trait SortedActiveTrait
{
    public function sortedActive(): Builder
    {
        return $this->where('status', StatusEnum::ACTIVE->value)
            ->orderBy('sort');
    }
}

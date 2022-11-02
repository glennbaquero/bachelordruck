<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverFoilQueryBuilder extends Builder
{
    public function sortedActive(): Builder
    {
        return $this->with('media')
            ->where('status', StatusEnum::ACTIVE->value)
            ->orderBy('sort');
    }
}

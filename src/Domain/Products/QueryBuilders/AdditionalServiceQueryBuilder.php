<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Traits\SortedActiveTrait;
use Illuminate\Database\Eloquent\Builder;

class AdditionalServiceQueryBuilder extends Builder
{
    use SortedActiveTrait;
}

<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Traits\SortedActiveTrait;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverImprintColorQueryBuilder extends Builder
{
    use SortedActiveTrait;
}

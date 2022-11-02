<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Traits\SortedActiveTrait;
use Illuminate\Database\Eloquent\Builder;

class ProductFormatQueryBuilder extends Builder
{
    use SortedActiveTrait;
}

<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Traits\SortedActiveTrait;
use Illuminate\Database\Eloquent\Builder;

class ProductCoverColorQueryBuilder extends Builder
{
    use SortedActiveTrait;
}

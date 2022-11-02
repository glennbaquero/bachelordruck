<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Traits\HasPositionCollection;
use Illuminate\Database\Eloquent\Collection;

class OrderPositionCollection extends Collection
{
    use HasPositionCollection;
}

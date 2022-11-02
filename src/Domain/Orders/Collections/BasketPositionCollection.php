<?php

namespace Domain\Orders\Collections;

use Domain\Orders\Traits\HasPositionCollection;
use Illuminate\Database\Eloquent\Collection;

class BasketPositionCollection extends Collection
{
    use HasPositionCollection;
}

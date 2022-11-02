<?php

namespace Domain\Orders\Actions;

use Carbon\Carbon;
use Domain\Orders\Models\BasketPosition;

class BasketPositionsClearAction
{
    public function __invoke(): void
    {
        $hours = config('bachelordruck.basket_position_removal_hours');

        BasketPosition::select('id', 'created_at')->where('created_at', '<=', Carbon::now()->subHours($hours)->toDateTimeString())->delete();
    }
}

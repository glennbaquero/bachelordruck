<?php

namespace Domain\Orders\Presets;

use Domain\Orders\Enums\PaymentStatusEnum;
use Domain\Orders\Models\OrderPayment;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentPreset
{
    public function __invoke(OrderPayment $orderPayment = new OrderPayment(), ?Model $parentModel = null): Model
    {
        $orderPayment->status = PaymentStatusEnum::CREATED;

        return $orderPayment;
    }
}

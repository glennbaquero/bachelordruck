<?php

namespace Domain\Orders\Presets;

use App\Enums\SalutationEnum;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderPreset
{
    public function __invoke(Order $order = new Order(), ?Model $parentModel = null): Model
    {
        $order->session_id = session()->getId();
        $order->customer_type = CustomerTypeEnum::PRIVATE;
        $order->title = SalutationEnum::MR->value;
        $order->is_recipient_different = false;
        $order->total_amount = 0.0;

        $order->payment = PaymentEnum::CASH;
        $order->status = StatusEnum::WAITING_FOR_PAYMENT;

        return $order;
    }
}

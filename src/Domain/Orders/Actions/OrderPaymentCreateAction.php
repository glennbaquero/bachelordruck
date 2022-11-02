<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderPaymentData;
use Domain\Orders\Models\OrderPayment;

class OrderPaymentCreateAction
{
    public function __invoke(OrderPaymentData $orderPaymentData): OrderPayment
    {
        return OrderPayment::create([
            'order_id' => $orderPaymentData->order_id,
            'reference' => $orderPaymentData->reference,
            'intent' => $orderPaymentData->intent,
            'status' => $orderPaymentData->status,
            'response' => $orderPaymentData->response,
        ]);
    }
}

<?php

namespace Domain\Orders\DataTransferObjects;

use Domain\Orders\Enums\IntentEnum;
use Domain\Orders\Enums\PaymentStatusEnum;
use Domain\Orders\Models\OrderPayment;
use Spatie\DataTransferObject\DataTransferObject;

class OrderPaymentData extends DataTransferObject
{
    public int $order_id;

    public string $reference;

    public IntentEnum $intent;

    public PaymentStatusEnum $status;

    public PaymentResponseData $response;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        int $order_id,
        string $reference,
        IntentEnum $intent,
        PaymentStatusEnum $status,
        PaymentResponseData $response
    ): OrderPaymentData {
        return new self(get_defined_vars());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromModel(OrderPayment $orderPayment): OrderPaymentData
    {
        return new self(
            order_id: $orderPayment->order_id,
            reference: $orderPayment->reference,
            intent: $orderPayment->intent,
            status: $orderPayment->status,
            response: new PaymentResponseData($orderPayment->response),
        );
    }
}

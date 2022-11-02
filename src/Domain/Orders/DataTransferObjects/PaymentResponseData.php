<?php

namespace Domain\Orders\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PaymentResponseData extends DataTransferObject
{
    public string $id = '';

    public string $intent = '';

    public string $status = '';

    public array $purchase_units = [];

    public array $payer = [];

    public string $create_time = '';

    public string $update_time = '';

    public array $links = [];

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $id,
        string $intent,
        string $status,
        array $purchase_units,
        array $payer,
        string $create_time,
        string $update_time,
        array $links = []
    ): PaymentResponseData {
        return new self(get_defined_vars());
    }
}

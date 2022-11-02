<?php

namespace Domain\Orders\DataTransferObjects;

use App\Enums\SalutationEnum;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;
use Spatie\DataTransferObject\DataTransferObject;

class OrderData extends DataTransferObject
{
    public string $session_id;

    public CustomerTypeEnum $customer_type;

    public ?SalutationEnum $title;

    public string $firstname;

    public string $lastname;

    public string $email;

    public ?string $phone;

    public string $street;

    public string $postal_code;

    public string $city;

    public bool $is_recipient_different;

    public ?SalutationEnum $recipient_title;

    public ?string $recipient_firstname;

    public ?string $recipient_lastname;

    public ?string $recipient_street;

    public ?string $recipient_postal_code;

    public ?string $recipient_city;

    public int $total_amount;

    public PaymentEnum $payment;

    public StatusEnum $status;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $session_id,
        CustomerTypeEnum $customer_type,
        string $firstname,
        string $lastname,
        string $email,
        string $street,
        string $postal_code,
        string $city,
        bool $is_recipient_different,
        int $total_amount,
        PaymentEnum $payment,
        StatusEnum $status,
        ?SalutationEnum $title = null,
        ?string $phone = null,
        ?SalutationEnum $recipient_title = null,
        ?string $recipient_firstname = null,
        ?string $recipient_lastname = null,
        ?string $recipient_street = null,
        ?string $recipient_postal_code = null,
        ?string $recipient_city = null,
    ): OrderData {
        return new self(get_defined_vars());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromModel(Order $order): OrderData
    {
        return new self(
            session_id: $order->session_id,
            customer_type: $order->customer_type,
            title: $order->title ?? null,
            firstname: $order->firstname,
            lastname: $order->lastname,
            email: $order->email,
            phone: $order->phone ?? null,
            street: $order->street,
            postal_code: $order->postal_code,
            city: $order->city,
            is_recipient_different: $order->is_recipient_different,
            recipient_title: $order->recipient_title ?? null,
            recipient_firstname: $order->recipient_firstname ?? null,
            recipient_lastname: $order->recipient_lastname ?? null,
            recipient_street: $order->recipient_street ?? null,
            recipient_postal_code: $order->recipient_postal_code ?? null,
            recipient_city: $order->recipient_city ?? null,
            total_amount: $order->total_amount,
            payment: $order->payment,
            status: $order->status,
        );
    }
}

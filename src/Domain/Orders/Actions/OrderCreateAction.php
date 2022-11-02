<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Models\Order;

class OrderCreateAction
{
    public function __invoke(OrderData $orderData): Order
    {
        return Order::create([
            'session_id' => $orderData->session_id,
            'customer_type' => $orderData->customer_type,
            'title' => $orderData->title,
            'firstname' => $orderData->firstname,
            'lastname' => $orderData->lastname,
            'email' => $orderData->email,
            'phone' => $orderData->phone,
            'street' => $orderData->street,
            'postal_code' => $orderData->postal_code,
            'city' => $orderData->city,
            'is_recipient_different' => $orderData->is_recipient_different,
            'recipient_title' => $orderData->recipient_title,
            'recipient_firstname' => $orderData->recipient_firstname,
            'recipient_lastname' => $orderData->recipient_lastname,
            'recipient_street' => $orderData->recipient_street,
            'recipient_postal_code' => $orderData->recipient_postal_code,
            'recipient_city' => $orderData->recipient_city,
            'total_amount' => $orderData->total_amount,
            'payment' => $orderData->payment,
            'status' => $orderData->status,
        ]);
    }
}

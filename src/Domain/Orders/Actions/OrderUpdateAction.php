<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Models\Order;

class OrderUpdateAction
{
    public function __invoke(Order $order, OrderData $orderData): Order
    {
        $order->session_id = $orderData->session_id;
        $order->customer_type = $orderData->customer_type;
        $order->title = $orderData->title;
        $order->firstname = $orderData->firstname;
        $order->lastname = $orderData->lastname;
        $order->email = $orderData->email;
        $order->phone = $orderData->phone;
        $order->street = $orderData->street;
        $order->postal_code = $orderData->postal_code;
        $order->city = $orderData->city;
        $order->is_recipient_different = $orderData->is_recipient_different;
        $order->recipient_title = $orderData->recipient_title;
        $order->recipient_firstname = $orderData->recipient_firstname;
        $order->recipient_lastname = $orderData->recipient_lastname;
        $order->recipient_street = $orderData->recipient_street;
        $order->recipient_postal_code = $orderData->recipient_postal_code;
        $order->recipient_city = $orderData->recipient_city;
        $order->total_amount = $orderData->total_amount;
        $order->payment = $orderData->payment;
        $order->status = $orderData->status;

        $order->save();

        return $order->refresh();
    }
}

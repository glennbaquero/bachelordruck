<?php

namespace Domain\Orders\Helpers;

class OrderCheckoutHelpers
{
    public static function checkoutUrls(): array
    {
        $language = 'de';

        return [
            route('order.basket-items', ['language' => $language]),
            route('order.contact-details', ['language' => $language]),
            route('order.payment', ['language' => $language, 'sessionId' => request()->get('sessionId', 'unknown')]),
            route('order.confirmation-and-data-upload', ['language' => $language, 'sessionId' => request()->get('sessionId', 'unknown')]),
        ];
    }
}

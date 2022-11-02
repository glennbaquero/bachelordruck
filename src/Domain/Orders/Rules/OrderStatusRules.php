<?php

namespace Domain\Orders\Rules;

use App\Contracts\AbstractRules;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class OrderStatusRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'customer_type' => [
                'in:'.implode(',', CustomerTypeEnum::keys()),
            ],
            'title' => [
                'string',
            ],
            'firstname' => [
                'string',
            ],
            'lastname' => [
                'string',
            ],
            'email' => [
                'string',
            ],
            'phone' => [
                'string',
            ],
            'street' => [
                'string',
            ],
            'postal_code' => [
                'string',
            ],
            'city' => [
                'string',
            ],
            'is_recipient_different' => [
                'boolean',
            ],
            'recipient_title' => [
                'nullable',
            ],
            'recipient_firstname' => [
                'nullable',
            ],
            'recipient_lastname' => [
                'nullable',
            ],
            'recipient_street' => [
                'nullable',
            ],
            'recipient_postal_code' => [
                'nullable',
                'string',
            ],
            'recipient_city' => [
                'nullable',
                'string',
            ],
            'total_amount' => [
                'nullable',
            ],
            'payment' => [
                'in:'.implode(',', PaymentEnum::keys()),
            ],
            'status' => [
                'required',
                'in:'.implode(',', StatusEnum::keys()),
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'order.');
    }
}

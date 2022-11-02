<?php

namespace Domain\Orders\Rules;

use App\Contracts\AbstractRules;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class OrderRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'session_id' => [
                'required',
                'max:40',
                'string',
            ],
            'customer_type' => [
                'required',
                'in:'.implode(',', CustomerTypeEnum::keys()),
            ],
            'title' => [
                'required',
                'max:50',
                'string',
            ],
            'firstname' => [
                'required',
                'max:50',
                'string',
            ],
            'lastname' => [
                'required',
                'max:50',
                'string',
            ],
            'email' => [
                'required',
                'max:255',
                'string',
            ],
            'phone' => [
                'nullable',
                'max:255',
                'string',
            ],
            'street' => [
                'required',
                'max:255',
                'string',
            ],
            'postal_code' => [
                'required',
                'max:13',
                'string',
            ],
            'city' => [
                'required',
                'max:255',
                'string',
            ],
            'is_recipient_different' => [
                'required',
                'boolean',
            ],
            'recipient_title' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:50',
                'string',
            ],
            'recipient_firstname' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:50',
                'string',
            ],
            'recipient_lastname' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:50',
                'string',
            ],
            'recipient_street' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:255',
                'string',
            ],
            'recipient_postal_code' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:13',
                'string',
            ],
            'recipient_city' => [
                'required_if:is_recipient_different,1',
                'nullable',
                'max:255',
                'string',
            ],
            'total_amount' => [
                'required',
                'integer',
            ],
            'payment' => [
                'required',
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

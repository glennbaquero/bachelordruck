<?php

namespace Domain\Orders\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class OrderPositionRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'order_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'qty' => [
                'required',
                'integer',
            ],
            'configuration' => [
                'nullable',
            ],
            'product_data' => [
                'nullable',
            ],
            'price' => [
                'required',
                'integer',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'orderPosition.');
    }
}

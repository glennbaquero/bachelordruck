<?php

namespace Domain\Orders\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class BasketPositionRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'session_id' => [
                'required',
                'max:40',
                'string',
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
            'price' => [
                'required',
                'integer',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'basketPosition.');
    }
}

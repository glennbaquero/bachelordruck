<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class AdditionalServiceRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'tooltip' => [
                'required',
                'string',
            ],
            'surcharge' => [
                'required',
                'integer',
            ],
            'sort' => [
                'required',
                'integer',
            ],
            'status' => [
                'required',
                'in:'.implode(',', StatusEnum::keys()),
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'additionalService.');
    }
}

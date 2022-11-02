<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class ProductCoverImprintColorRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'color' => [
                'required',
                'regex:/^#[0-9a-f]{6}$/i',
                'max:7',
                'string',
            ],
            'is_preselected' => [
                'required',
                'boolean',
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

        return ArrayHelpers::keyPrepend($rules, 'productCoverImprintColor.');
    }
}

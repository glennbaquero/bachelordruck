<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class ProductBookSpineColorRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'product.title' => [
                'sometimes',
                'string',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
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

        return ArrayHelpers::keyPrepend($rules, 'productBookSpineColor.');
    }
}

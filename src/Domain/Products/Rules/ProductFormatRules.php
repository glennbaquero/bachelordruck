<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class ProductFormatRules extends AbstractRules
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

        return ArrayHelpers::keyPrepend($rules, 'productFormat.');
    }
}

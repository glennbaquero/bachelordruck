<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Support\Helpers\ArrayHelpers;

class ProductPaperThicknessRules extends AbstractRules
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
            'tooltip' => [
                'required',
                'max:255',
                'string',
            ],
            'max_pages' => [
                'nullable',
                'integer',
            ],
            'price_per_page_bw' => [
                'required',
                'integer',
            ],
            'price_per_page_color' => [
                'required',
                'integer',
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

        return ArrayHelpers::keyPrepend($rules, 'productPaperThickness.');
    }
}

<?php

namespace Domain\Products\Rules;

use App\Contracts\AbstractRules;
use Domain\Products\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class ProductRules extends AbstractRules
{
    protected ?Model $model;

    public function __construct(?Model $model = null)
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        $rules = [
            'slug' => [
                'required',
                'max:255',
                Rule::unique('news', 'slug')->ignore($this->model?->id),
                'string',
            ],
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'tooltip' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'integer',
            ],
            'has_cover_color' => [
                'required',
                'boolean',
            ],
            'has_cover_imprint_color' => [
                'required',
                'boolean',
            ],
            'has_cover_foil' => [
                'required',
                'boolean',
            ],
            'has_back_cover' => [
                'required',
                'boolean',
            ],
            'has_book_spine_label' => [
                'required',
                'boolean',
            ],
            'book_spine_label_surcharge' => [
                'required',
                'integer',
            ],
            'has_book_corners' => [
                'required',
                'boolean',
            ],
            'book_corners_surcharge' => [
                'required',
                'integer',
            ],
            'has_ribbon' => [
                'required',
                'boolean',
            ],
            'ribbon_surcharge' => [
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

        return ArrayHelpers::keyPrepend($rules, 'product.');
    }
}

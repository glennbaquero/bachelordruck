<?php

namespace Domain\Banners\Rules;

use App\Contracts\AbstractRules;
use App\Enums\StatusEnum;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class BannerRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'page_id' => [
                'required',
                Rule::exists('pages', 'id'),
                'integer',
            ],
            'language_id' => [
                'required',
                Rule::exists('cms_languages', 'id'),
                'integer',
            ],
            'transmission' => [
                'nullable',
                'boolean',
            ],
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'description' => [
                'sometimes',
                'max:255',
                'string',
            ],
            'url' => [
                'nullable',
                'max:255',
                'string',
            ],
            'link_text' => [
                'nullable',
                'max:255',
                'string',
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

        return ArrayHelpers::keyPrepend($rules, 'banner.');
    }
}

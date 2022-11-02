<?php

namespace Domain\Pages\Rules;

use App\Contracts\AbstractRules;
use Domain\Pages\Enums\TargetTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class PageLanguageRules extends AbstractRules
{
    protected ?Model $model;

    protected ?bool  $isUpdate;

    public function __construct(?Model $model)
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        $rules = [
            'page_id' => [
                'nullable',
                Rule::exists('pages', 'id'),
                'integer',
            ],
            'language_id' => [
                'required',
                Rule::exists('cms_languages', 'id'),
                'integer',
            ],
            'url' => [
                'required',
                'max:255',
                'string',
            ],
            'target_type' => [
                'required',
                'in:'.implode(',', TargetTypeEnum::keys()),
                'string',
            ],
            'name' => [
                'required',
                'max:255',
                'string',
            ],
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'layout_id' => [
                'nullable',
                Rule::exists('layouts', 'id'),
                'int',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'active' => [
                'nullable',
                'boolean',
            ],
            'visible' => [
                'nullable',
                'boolean',
            ],

        ];

        return [
            ...['page.parent_id' => [
                'required', // Root Nodes have to be created by seeder or manually
                Rule::exists('pages', 'id'),
                'integer',
            ]],
            ...ArrayHelpers::keyPrepend($rules, 'pageLanguage.'),
        ];
    }
}

<?php

namespace Domain\Galleries\Rules;

use App\Contracts\AbstractRules;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class GalleryRules extends AbstractRules
{
    protected ?Model $model;

    public function __construct(?Model $model = null)
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        $rules = [
            'language_id' => [
                'required',
                Rule::exists('cms_languages', 'id'),
                'integer',
            ],
            'page_id' => [
                'sometimes',
                Rule::exists('pages', 'id'),
                'nullable',
                'integer',
            ],
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'description' => [
                'nullable',
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
            'slug' => [
                'required',
                'max:255',
                Rule::unique('news', 'slug')->ignore($this->model?->id),
                'string',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'gallery.');
    }
}

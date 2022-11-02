<?php

namespace Domain\News\Rules;

use App\Contracts\AbstractRules;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class NewsRules extends AbstractRules
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
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'description' => [
                'required',
                'max:65535',
                'string',
            ],
            'slug' => [
                'required',
                'max:255',
                'string',
                Rule::unique('news', 'slug')->ignore($this->model?->id),
            ],
            'news_date' => [
                'required',
                'date',
            ],
            'status' => [
                'required',
                'in:'.implode(',', StatusEnum::keys()),
            ],
            'video_url' => [
                'nullable',
                'string',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'news.');
    }
}

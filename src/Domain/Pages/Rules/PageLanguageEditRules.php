<?php

namespace Domain\Pages\Rules;

use App\Contracts\AbstractRules;
use Illuminate\Database\Eloquent\Model;

class PageLanguageEditRules extends AbstractRules
{
    protected ?Model $model;

    public function __construct(?Model $model)
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        $rules = PageLanguageRules::getRules();

        unset($rules['page.parent_id'], $rules['pageLanguage.language_id']);

        return $rules;
    }
}

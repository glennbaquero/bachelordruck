<?php

namespace Domain\Users\Rules;

use App\Contracts\AbstractRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Support\Helpers\ArrayHelpers;

class UserRules extends AbstractRules
{
    protected ?Model $model;

    public function __construct(?Model $model = null)
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'max:255',
                'string',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                Rule::unique('users', 'email')->ignore($this->model?->id),
                'string',
            ],
            'color' => [
                'nullable',
                'size: 7',
                'regex:/^#[0-9a-f]{6}$/i',
                'string',
            ],
            'initials' => [
                'required',
                'max: 3',
                'regex:/^[0-9A-Z]{1,3}$/',
                'string',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'user.', 'avatar');
    }
}

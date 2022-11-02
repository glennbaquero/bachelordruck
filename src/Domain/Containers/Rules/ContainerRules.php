<?php

namespace Domain\Containers\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class ContainerRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'sort' => [
                'required',
                'integer',
            ],
            'title' => [
                'nullable',
                'max:255',
                'string',
            ],
            'image_alignment' => [
                'nullable',
                'max:255',
                'string',
            ],
            'content' => [
                'nullable',
            ],
            'type' => [
                'required',
                'max:255',
                'string',
            ],
            'options' => [
                'nullable',
                'string',
            ],
            'pages_language_id' => [
                'required',
                'integer',
            ],
            'url' => [
                'nullable',
                'max:255',
                'string',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'container.');
    }
}

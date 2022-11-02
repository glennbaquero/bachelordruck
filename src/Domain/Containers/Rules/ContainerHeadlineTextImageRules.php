<?php

namespace Domain\Containers\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class ContainerHeadlineTextImageRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'sort' => [
                'required',
                'integer',
            ],
            'title' => [
                'sometimes',
                'max:255',
                'string',
            ],
            'image_alignment' => [
                'required',
                'max:255',
                'string',
            ],
            'content' => [
                'required',
                'string',
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
            'image' => [
                'required',
                'array',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'container.');
    }
}

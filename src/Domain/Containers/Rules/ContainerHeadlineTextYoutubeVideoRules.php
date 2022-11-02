<?php

namespace Domain\Containers\Rules;

use App\Contracts\AbstractRules;
use Support\Helpers\ArrayHelpers;

class ContainerHeadlineTextYoutubeVideoRules extends AbstractRules
{
    public function rules(): array
    {
        $rules = [
            'sort' => [
                'required',
                'integer',
            ],
            'title' => [
                'required',
                'max:255',
                'string',
            ],
            'image_alignment' => [
                'nullable',
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
                'required',
                'url',
                'max:255',
                'string',
            ],
            'media' => 'sometimes',
        ];

        return ArrayHelpers::keyPrepend($rules, 'container.');
    }
}

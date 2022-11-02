<?php

namespace Domain\Products\Rules;

use Support\Helpers\ArrayHelpers;

class ProductConfigurationRules
{
    protected int $maxPages;

    protected int $numberOfColoredPages;

    public static function getRules(int $maxPages, int $numberOfColoredPages): array
    {
        $self = new static();

        $self->maxPages = $maxPages;
        $self->numberOfColoredPages = $numberOfColoredPages;

        return $self->rules();
    }

    public function rules(): array
    {
        $rules = [
            'total_number_of_pages' => 'integer|numeric|max:'.$this->maxPages,
            'number_of_colored_pages' => 'integer|numeric|max:'.$this->numberOfColoredPages,
            'book_spine_label' => [
                'exclude_if:productConfiguration.has_book_spine_label,false',
                'exclude_if:productConfiguration.has_book_spine_label,0',
                'required_if:productConfiguration.has_book_spine_label,true',
                'required_if:productConfiguration.has_book_spine_label,1',
                'max:60',
            ],
        ];

        return ArrayHelpers::keyPrepend($rules, 'productConfiguration.');
    }
}

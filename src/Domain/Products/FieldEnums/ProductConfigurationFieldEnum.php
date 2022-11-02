<?php

namespace Domain\Products\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum ProductConfigurationFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case TOTAL_NUMBER_OF_PAGES = 'total_number_of_pages';
    case NUMBER_OF_COLORED_PAGES = 'number_of_colored_pages';
    case BOOK_SPINE_LABEL = 'book_spine_label';

    public function payload(): array
    {
        return [];
    }
}

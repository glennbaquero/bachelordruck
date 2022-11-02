<?php

namespace Domain\Pages\DataTransferObjects;

use Domain\Pages\Models\Page;
use Spatie\DataTransferObject\DataTransferObject;

class PageData extends DataTransferObject
{
    public ?int $parent_id = 0;

    public static function fromModel(Page $page): PageData
    {
        return new self(
            parent_id: $page->parent_id,
        );
    }
}

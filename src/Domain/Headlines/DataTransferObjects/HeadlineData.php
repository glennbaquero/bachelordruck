<?php

namespace Domain\Headlines\DataTransferObjects;

use Domain\Headlines\Models\Headline;
use Spatie\DataTransferObject\DataTransferObject;

class HeadlineData extends DataTransferObject
{
    public string $title;

    public int $container_id;

    public static function fromModel(Headline $headline): HeadlineData
    {
        return new self(
            title: $headline->title,
            container_id: $headline->container_id
        );
    }
}

<?php

namespace Domain\Richtexts\DataTransferObjects;

use Domain\Richtexts\Models\Richtext;
use Spatie\DataTransferObject\DataTransferObject;

class RichtextData extends DataTransferObject
{
    public string $body;

    public int $container_id;

    public static function fromModel(Richtext $richtext): RichtextData
    {
        return new self(
            body: $richtext->body,
            container_id: $richtext->container_id
        );
    }
}

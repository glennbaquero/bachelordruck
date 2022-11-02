<?php

namespace Domain\Images\DataTransferObjects;

use Domain\Images\Models\Image;
use Spatie\DataTransferObject\DataTransferObject;

class ImageData extends DataTransferObject
{
    public string $description;

    public string $display_mode;

    public int $container_id;

    public static function fromModel(Image $image): ImageData
    {
        return new self(
            description: $image->description,
            display_mode: $image->display_mode,
            container_id: $image->container_id
        );
    }
}

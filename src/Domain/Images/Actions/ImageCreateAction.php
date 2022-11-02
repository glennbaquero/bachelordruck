<?php

namespace Domain\Images\Actions;

use Domain\Images\DataTransferObjects\ImageData;
use Domain\Images\Models\Image;

class ImageCreateAction
{
    public function __invoke(ImageData $imageData): Image
    {
        return Image::create([
            'description' => $imageData->description,
            'display_mode' => $imageData->display_mode,
            'container_id' => $imageData->container_id,
        ]);
    }
}

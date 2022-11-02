<?php

namespace Domain\Images\Actions;

use Domain\Images\DataTransferObjects\ImageData;
use Domain\Images\Models\Image;

class ImageUpdateAction
{
    public function __invoke(Image $image, ImageData $imageData): Image
    {
        $image->display_mode = $imageData->display_mode;
        $image->container_id = $imageData->container_id;
        $image->description = $imageData->description;
        $image->save();

        return $image->refresh();
    }
}

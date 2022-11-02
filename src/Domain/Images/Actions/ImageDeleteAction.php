<?php

namespace Domain\Images\Actions;

class ImageDeleteAction
{
    public function __invoke(Image $image): void
    {
        $image->delete();
    }
}

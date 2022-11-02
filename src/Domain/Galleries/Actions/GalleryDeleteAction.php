<?php

namespace Domain\Galleries\Actions;

use Domain\Galleries\Models\Gallery;

class GalleryDeleteAction
{
    public function __invoke(Gallery $gallery): void
    {
        $gallery->delete();
    }
}

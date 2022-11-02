<?php

namespace Domain\Galleries\Actions;

use Domain\Galleries\DataTransferObjects\GalleryData;
use Domain\Galleries\Models\Gallery;

class GalleryCreateAction
{
    public function __invoke(GalleryData $galleryData): Gallery
    {
        return Gallery::create([
            'language_id' => $galleryData->language_id,
            'page_id' => $galleryData->page_id,
            'title' => $galleryData->title,
            'description' => $galleryData->description,
            'status' => $galleryData->status,
            'sort' => $galleryData->sort,
            'slug' => $galleryData->slug,
        ]);
    }
}

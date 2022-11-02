<?php

namespace Domain\Galleries\Actions;

use Domain\Galleries\DataTransferObjects\GalleryData;
use Domain\Galleries\Models\Gallery;

class GalleryUpdateAction
{
    public function __invoke(Gallery $gallery, GalleryData $galleryData): Gallery
    {
        $gallery->fill([
            'language_id' => $galleryData->language_id,
            'page_id' => $galleryData->page_id ?? null,
            'title' => $galleryData->title,
            'description' => $galleryData->description,
            'status' => $galleryData->status,
            'sort' => $galleryData->sort,
        ])->save();

        return $gallery->refresh();
    }
}

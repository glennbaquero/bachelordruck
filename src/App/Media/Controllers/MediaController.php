<?php

namespace App\Media\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController
{
    public function download(Media $media)
    {
        return response()->download($media->getPath(), $media->file_name);
    }
}

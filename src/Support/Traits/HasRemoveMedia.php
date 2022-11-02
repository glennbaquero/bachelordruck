<?php

namespace Support\Traits;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasRemoveMedia
{
    public function removeMedia(int $id): void
    {
        $media = Media::find($id);

        Storage::disk($media->disk)->delete($media->id.'/'.$media->file_name);

        $media->delete();
    }
}

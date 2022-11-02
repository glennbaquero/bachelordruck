<?php

namespace Domain\MediaLibraries\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    public function signedUrl(): Attribute
    {
        return Attribute::get(function () {
            return url()->signedRoute('files-upload.download', ['media' => $this->uuid, 'fileName' => $this->file_name]);
        });
    }
}

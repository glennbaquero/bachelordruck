<?php

namespace App\Gallery\Controllers\Api;

use App\Gallery\Queries\GalleryIndexQuery;
use App\Gallery\Resources\GalleryResource;

class GalleryController
{
    public function index(GalleryIndexQuery $query)
    {
        return GalleryResource::collection($query->paginate(100));
    }
}

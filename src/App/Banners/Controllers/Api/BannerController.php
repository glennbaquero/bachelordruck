<?php

namespace App\Banners\Controllers\Api;

use App\Banners\Queries\BannerIndexQuery;
use App\Banners\Resources\BannerResource;

class BannerController
{
    public function index(BannerIndexQuery $query)
    {
        return BannerResource::collection($query->paginate(100));
    }
}

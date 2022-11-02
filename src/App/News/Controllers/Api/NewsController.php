<?php

namespace App\News\Controllers\Api;

use App\News\Queries\NewsIndexQuery;
use App\News\Resources\NewsResource;

class NewsController
{
    public function index(NewsIndexQuery $query)
    {
        return NewsResource::collection($query->paginate(100));
    }
}

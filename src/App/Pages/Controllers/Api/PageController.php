<?php

namespace App\Pages\Controllers\Api;

use App\Pages\Queries\PageIndexQuery;
use App\Pages\Resources\PageResources;

class PageController
{
    public function index(PageIndexQuery $query)
    {
        return PageResources::collection($query->paginate(100));
    }
}

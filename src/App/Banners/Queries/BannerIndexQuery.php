<?php

namespace App\Banners\Queries;

use Domain\Banners\Models\Banner;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BannerIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Banner::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            [
                AllowedFilter::scope('search'),
                'page_id',
                'language_id',
            ]
        );
    }
}

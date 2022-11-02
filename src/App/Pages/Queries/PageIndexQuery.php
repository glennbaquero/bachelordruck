<?php

namespace App\Pages\Queries;

use Domain\Pages\Models\PageLanguage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PageIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = PageLanguage::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            [
                AllowedFilter::scope('search'),
                AllowedFilter::exact('page_id'),
                AllowedFilter::exact('language_id'),
                AllowedFilter::exact('url'),
            ]
        )
        ->allowedIncludes([
            'page',
        ]);
    }
}

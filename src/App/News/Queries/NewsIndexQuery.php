<?php

namespace App\News\Queries;

use Domain\News\Models\News;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class NewsIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = News::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            [
                AllowedFilter::scope('search'),
                'language_id',
                'slug',
                AllowedFilter::exact('news_date'),
            ]
        );
    }
}

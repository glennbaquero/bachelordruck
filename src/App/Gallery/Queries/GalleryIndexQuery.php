<?php

namespace App\Gallery\Queries;

use Domain\Galleries\Models\Gallery;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GalleryIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Gallery::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            [
                AllowedFilter::exact('id'),
                AllowedFilter::scope('search'),
                'language_id',
                AllowedFilter::exact('status'),
            ]
        );
    }
}

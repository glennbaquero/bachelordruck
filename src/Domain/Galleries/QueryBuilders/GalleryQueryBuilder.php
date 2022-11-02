<?php

namespace Domain\Galleries\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class GalleryQueryBuilder extends Builder
{
    public function active()
    {
        return $this->where('status', 'active');
    }

    public function language($languageId)
    {
        return $this->where('language_id', $languageId);
    }

    public function orderBySort()
    {
        return $this->orderBy('sort', 'DESC');
    }
}

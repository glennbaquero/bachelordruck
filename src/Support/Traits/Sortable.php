<?php

namespace Support\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait Sortable
{
    public function nextSortValue(Model $model, ?Model $parentModel = null, int $increment = 5, string $sortColumn = 'sort'): int
    {
        return ($model->newQuery()
            ->when($parentModel, function (Builder $builder) use ($parentModel) {
                $builder->whereBelongsTo($parentModel);
            })
            ->max($sortColumn) ?? 0) + $increment;
    }
}

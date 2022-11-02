<?php

namespace Domain\Products\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class PreSelectedFieldResetAction
{
    /**
     * @throws RuntimeException
     */
    public function __invoke(Model $model, bool $preSelectedState, ?string $parentFieldName = null): void
    {
        if ($preSelectedState === false) {
            return;
        }

        if (! empty($parentFieldName) && ! $model->{$parentFieldName}) {
            throw new RuntimeException('Model parent is not set.');
        }

        $model->newQuery()
            ->when(! empty($parentFieldName), function (Builder $builder) use ($model, $parentFieldName) {
                $builder->where($parentFieldName, $model->{$parentFieldName});
            })
            ->when($model->id, function (Builder $builder) use ($model) {
                $builder->where('id', '!=', $model->id);
            })
            ->update([
                'is_preselected' => false,
            ]);
    }
}

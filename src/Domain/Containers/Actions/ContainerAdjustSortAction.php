<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Models\Container;
use Illuminate\Support\Facades\DB;

/**
 * Adjust the sort column values which value is higher than the
 * provided container parameter. This usually used during deletion
 * of container and adjusting the sorting value to occupy the current
 * sort position of the deleted container.
 */
class ContainerAdjustSortAction
{
    public function __invoke(Container $container): void
    {
        Container::query()
            ->where('pages_language_id', $container->pages_language_id)
            ->where('sort', '>', $container->sort)
            ->update([
                'sort' => DB::raw('`sort` - 1'),
            ]);
    }
}

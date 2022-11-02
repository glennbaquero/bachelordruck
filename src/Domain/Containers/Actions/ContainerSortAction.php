<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Models\Container;

/**
 * This update the sort values of the affected containers during the arrangement
 * of position in UI display.
 */
class ContainerSortAction
{
    public function __invoke(array $sortedContainers): void
    {
        Container::query()->upsert($sortedContainers, ['id'], ['sort']);
    }
}

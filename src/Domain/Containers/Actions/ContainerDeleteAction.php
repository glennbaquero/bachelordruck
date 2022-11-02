<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Models\Container;

class ContainerDeleteAction
{
    public function __invoke(Container $container): void
    {
        // Updates the affected containers sort column values
        app(ContainerAdjustSortAction::class)($container);

        $container->delete();
    }
}

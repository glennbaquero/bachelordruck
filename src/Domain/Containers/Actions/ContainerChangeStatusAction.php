<?php

namespace Domain\Containers\Actions;

use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Models\Container;

class ContainerChangeStatusAction
{
    public function __invoke(Container $container, ContainerStatusEnum $status): Container
    {
        $container->status = $status;
        $container->save();

        return $container;
    }
}

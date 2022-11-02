<?php

namespace Domain\Containers\Tasks;

use Closure;
use Domain\Containers\Actions\ContainerChangeStatusAction;
use Domain\Containers\Actions\ContainerTranslateTextAction;
use Domain\Containers\Enums\ContainerStatusEnum;
use Domain\Containers\Models\Container;

class TranslateContainerTask
{
    public function handle(Container $container, Closure $next)
    {
        $container = app(ContainerChangeStatusAction::class)($container, ContainerStatusEnum::TRANSLATING);

        app(ContainerTranslateTextAction::class)($container);

        return $next($container);
    }
}

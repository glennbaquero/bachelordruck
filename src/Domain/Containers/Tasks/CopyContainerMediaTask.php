<?php

namespace Domain\Containers\Tasks;

use Closure;
use Domain\Containers\Actions\ContainerCopyMediaFromSourceAction;
use Domain\Containers\Models\Container;

class CopyContainerMediaTask
{
    public function handle(Container $container, Closure $next)
    {
        app(ContainerCopyMediaFromSourceAction::class)($container);

        return $next($container);
    }
}

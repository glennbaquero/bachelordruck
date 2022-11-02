<?php

namespace Domain\Containers\Actions;

use Domain\Containers\DataTransferObjects\ContainerData;
use Domain\Containers\Models\Container;

class ContainerUpdateAction
{
    public function __invoke(Container $container, ContainerData $containerData): Container
    {
        unset($container->image);

        $container->sort = $containerData->sort;
        $container->title = $containerData->title;
        $container->image_alignment = $containerData->image_alignment;
        $container->content = $containerData->content;
        $container->type = $containerData->type;
        $container->options = $containerData->options;
        $container->pages_language_id = $containerData->pages_language_id;
        $container->url = $containerData->url;

        $container->save();

        return $container->refresh();
    }
}

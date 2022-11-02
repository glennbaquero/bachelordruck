<?php

namespace Domain\Containers\Actions;

use Domain\Containers\DataTransferObjects\ContainerData;
use Domain\Containers\Models\Container;

class ContainerCreateAction
{
    public function __invoke(ContainerData $containerData): Container
    {
        return Container::create([
            'sort' => $containerData->sort,
            'title' => $containerData->title,
            'image_alignment' => $containerData->image_alignment,
            'content' => $containerData->content,
            'type' => $containerData->type,
            'options' => $containerData->options,
            'pages_language_id' => $containerData->pages_language_id,
            'url' => $containerData->url,
        ]);
    }
}

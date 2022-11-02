<?php

namespace Domain\Headlines\Actions;

use Domain\Headlines\DataTransferObjects\HeadlineData;
use Domain\Headlines\Models\Headline;

class HeadlineCreateAction
{
    public function __invoke(HeadlineData $headlineData): Headline
    {
        return Headline::create([
            'title' => $headlineData->title,
            'container_id' => $headlineData->container_id,
        ]);
    }
}

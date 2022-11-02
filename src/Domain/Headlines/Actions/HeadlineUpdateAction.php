<?php

namespace Domain\Headlines\Actions;

use Domain\Headlines\DataTransferObjects\HeadlineData;
use Domain\Headlines\Models\Headline;

class HeadlineUpdateAction
{
    public function __invoke(Headline $headline, HeadlineData $headlineData): Headline
    {
        $headline->title = $headlineData->title;
        $headline->container_id = $headlineData->container_id;
        $headline->save();

        return $headline->refresh();
    }
}

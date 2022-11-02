<?php

namespace Domain\Richtexts\Actions;

use Domain\Richtexts\DataTransferObjects\RichtextData;
use Domain\Richtexts\Models\Richtext;

class RichtextCreateAction
{
    public function __invoke(RichtextData $richtextData): Richtext
    {
        return Richtext::create([
            'body' => $richtextData->body,
            'container_id' => $richtextData->container_id,
        ]);
    }
}

<?php

namespace Domain\Richtexts\Actions;

use Domain\Richtexts\DataTransferObjects\RichtextData;
use Domain\Richtexts\Models\Richtext;

class RichtextUpdateAction
{
    public function __invoke(Richtext $richtext, RichtextData $richtextData): Richtext
    {
        $richtext->body = $richtextData->body;
        $richtext->container_id = $richtextData->container_id;
        $richtext->save();

        return $richtext->refresh();
    }
}

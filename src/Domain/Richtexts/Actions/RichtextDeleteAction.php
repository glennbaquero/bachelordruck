<?php

namespace Domain\Richtexts\Actions;

use Domain\Richtexts\Models\Richtext;

class RichtextDeleteAction
{
    public function __invoke(Richtext $richtext): void
    {
        $richtext->delete();
    }
}

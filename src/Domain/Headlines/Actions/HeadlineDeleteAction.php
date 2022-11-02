<?php

namespace Domain\Headlines\Actions;

use Domain\Headlines\Models\Headline;

class HeadlineDeleteAction
{
    public function __invoke(Headline $headline): void
    {
        $headline->delete();
    }
}

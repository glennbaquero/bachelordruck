<?php

namespace App\Livewire\Domain\Pages\Show;

use App\Livewire\Base\Show;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\ShowGrids\PageShowGrid;

class PageShow extends Show
{
    public string $name = 'pagelanguage';

    public PageLanguage $model;

    public function mount(PageLanguage $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(PageShowGrid::class)();
    }
}

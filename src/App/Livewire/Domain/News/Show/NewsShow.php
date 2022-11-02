<?php

namespace App\Livewire\Domain\News\Show;

use App\Livewire\Base\Show;
use Domain\News\Actions\NewsDeleteAction;
use Domain\News\Models\News;
use Domain\News\ShowGrids\NewsShowGrid;
use Livewire\Redirector;

class NewsShow extends Show
{
    public string $name = 'news';

    public News   $model;

    public function mount(News $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(NewsShowGrid::class)();
    }

    public function delete(NewsDeleteAction $newsDeleteAction): Redirector
    {
        $newsDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('news.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('news.edit', ['model' => $this->model->id]));
    }
}

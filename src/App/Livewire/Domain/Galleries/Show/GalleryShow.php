<?php

namespace App\Livewire\Domain\Galleries\Show;

use App\Livewire\Base\Show;
use Domain\Galleries\Actions\GalleryDeleteAction;
use Domain\Galleries\Models\Gallery;
use Domain\Galleries\ShowGrids\GalleryShowGrid;

class GalleryShow extends Show
{
    public string $name = 'gallery';

    public Gallery   $model;

    public function mount(Gallery $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(GalleryShowGrid::class)();
    }

    public function delete(GalleryDeleteAction $galleryDeleteAction): Redirector
    {
        $galleryDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('galleries.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('galleries.edit', ['model' => $this->model->id]));
    }
}

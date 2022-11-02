<?php

namespace App\Livewire\Domain\Banners\Show;

use App\Livewire\Base\Show;
use Domain\Banners\Actions\BannerDeleteAction;
use Domain\Banners\Models\Banner;
use Domain\Banners\ShowGrids\BannerShowGrid;
use Livewire\Redirector;

class BannerShow extends Show
{
    public string $name = 'banner';

    public Banner   $model;

    public function mount(Banner $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(BannerShowGrid::class)();
    }

    public function delete(BannerDeleteAction $bannerDeleteAction): Redirector
    {
        $bannerDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('banner.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('banner.edit', ['model' => $this->model->id]));
    }
}

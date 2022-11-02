<?php

namespace App\Livewire\Domain\Banners\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Banners\Actions\BannerDeleteAction;
use Domain\Banners\Models\Banner;
use Domain\Pages\Models\Page;
use Illuminate\Database\Eloquent\Builder;

class BannersList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.banners')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.banner')]);
        $this->createRoute = route('banner.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/banners/%s', $id))
            ),
            Column::select(
                field: 'page_id',
                token: 'banner',
                options: Page::getSelectTree()
            ),
            Column::boolean(
                field: 'transmission',
                token: 'banner'
            )->sortable(),
            Column::text(
                field: 'title',
                token: 'banner'
            )->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/banners/%s/edit', $id))
            ),
            Column::action(
                action: 'delete'
            )->setCallback(
                function ($id) {
                    $this->currentId = $id;
                    $this->showModalConfirmation = true;
                }
            ),
        ];
    }

    public function query(): Builder
    {
        return Banner::query()->with('media');
    }

    public function delete(BannerDeleteAction $bannerDeleteAction, Banner $banner): void
    {
        if ($banner->id === null) {
            $banner = Banner::findOrFail($this->currentId);
        }

        $bannerDeleteAction($banner);
        $this->showModalConfirmation = false;
    }
}

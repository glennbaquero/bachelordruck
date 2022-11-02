<?php

namespace App\Livewire\Domain\Galleries\Lists;

use App\Enums\StatusEnum;
use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Galleries\Actions\GalleryDeleteAction;
use Domain\Galleries\Models\Gallery;
use Illuminate\Database\Eloquent\Builder;

class GalleryList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.galleries')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.gallery')]);
        $this->createRoute = route('gallery.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/galleries/%s', $id))
            ),
            Column::text(
                field: 'title',
                token: 'gallery',
            )->sortable(),
            Column::language(
                field: 'language_id',
                token: 'gallery'
            )->sortable(),
            Column::enum(
                field: 'status',
                token: 'gallery',
                enum: StatusEnum::class,
            )->sortable(),

            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/galleries/%s/edit', $id))
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
        return Gallery::query();
    }

    public function delete(GalleryDeleteAction $galleryDeleteAction, Gallery $gallery)
    {
        if ($gallery->id === null) {
            $gallery = Gallery::findOrFail($this->currentId);
        }

        $galleryDeleteAction($gallery);
        $this->showModalConfirmation = false;
    }
}

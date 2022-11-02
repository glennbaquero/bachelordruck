<?php

namespace App\Livewire\Domain\News\Lists;

use App\Enums\StatusEnum;
use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\News\Actions\NewsDeleteAction;
use Domain\News\Models\News;
use Illuminate\Database\Eloquent\Builder;

class NewsList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.news')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.news')]);
        $this->createRoute = route('news.create');
    }

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/news/%s', $id))
            ),
            Column::text(
                field: 'title',
                token: 'news'
            )->sortable(),
            Column::language(
                field: 'language_id',
                token: 'news'
            )->sortable(),
            Column::enum(
                field: 'status',
                token: 'news',
                enum: StatusEnum::class,
            )->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/news/%s/edit', $id))
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

    /**
     * {@inheritDoc}
     */
    public function query(): Builder
    {
        return News::query();
    }

    public function delete(NewsDeleteAction $newsDeleteAction, News $news)
    {
        if ($news->id === null) {
            $news = News::findOrFail($this->currentId);
        }

        $newsDeleteAction($news);
        $this->showModalConfirmation = false;
    }
}

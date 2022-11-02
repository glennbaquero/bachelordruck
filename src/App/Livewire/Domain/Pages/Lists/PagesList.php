<?php

namespace App\Livewire\Domain\Pages\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use App\Pages\Events\PageDeleted;
use Domain\Pages\Actions\PageDeleteAction;
use Domain\Pages\Actions\PageLanguageDeleteAction;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PagesList extends Component
{
    public array      $pages;

    public Collection $languages;

    public function mount(): void
    {
        $this->loadPages();
        $this->languages = Language::all();
    }

    private function loadPages()
    {
        $this->pages = Page::with([
            'ancestors:id',
            'pagesLanguage:id,page_id,name,language_id',
        ])->get(['id', 'parent_id', '_lft', '_rgt'])->toTree()->toArray();
    }

    public function render()
    {
        return view('livewire.pageList')
            ->with([
                'pages' => $this->pages,
                'languages' => $this->languages,
            ]);
    }

    public function up(int $page_id)
    {
        Page::findOrFail($page_id)->up();
        $this->loadPages();
    }

    public function down(int $page_id)
    {
        Page::findOrFail($page_id)->down();
        $this->loadPages();
    }

    public function delete(int $page_id, PageDeleteAction $pageDeleteAction)
    {
        $pageDeleteAction(Page::findOrFail($page_id));
        PageDeleted::dispatch();
        $this->loadPages();
    }
}

class PagesListX extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.pages')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.page')]);
        $this->createRoute = route('page.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/pages/%s', $id))
            ),
            Column::text(
                field: 'name',
                token: 'pagelanguage'
            ),
            Column::text(
                field: 'language',
                token: 'pagelanguage'
            ),
            Column::text(
                field: 'layout',
                token: 'pagelanguage'
            ),
            Column::boolean(
                field: 'active',
                token: 'pagelanguage',
            ),
            Column::boolean(
                field: 'visible',
                token: 'pagelanguage',
            ),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/pages/%s/edit', $id))
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
        return PageLanguage::query();
    }

    public function delete(PageLanguageDeleteAction $pageDeleteAction, PageLanguage $pageLanguage): void
    {
        //TODO: bug found when deleting, issue is with frontend!
        //        if ($pageLanguage->id === null) {
        //            $pageLanguage = PageLanguage::findOrFail($this->currentId);
        //        }
        //
        //        $pageDeleteAction($pageLanguage);
        $this->showModalConfirmation = false;
    }
}

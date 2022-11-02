<?php

namespace App\Livewire\Domain\Pages\Create;

use App\Livewire\Base\Form;
use App\Pages\Events\PageCreated;
use Domain\Pages\Actions\PageLanguageCreateAction;
use Domain\Pages\DataTransferObjects\PageData;
use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\Enums\TargetTypeEnum;
use Domain\Pages\FieldEnums\PageLanguageFieldEnum;
use Domain\Pages\FormGrids\PageLanguageFormGrid;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Layout;
use Domain\Pages\Models\Page;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\Rules\PageLanguageRules;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Redirector;

class PageCreate extends Form
{
    public string       $name = 'pageLanguage';

    public PageLanguage $pageLanguage;

    public Page         $page;

    public string       $method = 'create';

    public function mount(): void
    {
        $this->listRouteRedirect = route('page.list');

        $this->page = new Page();

        $this->page->parent_id = null;

        $this->pageLanguage = new PageLanguage();
        $this->pageLanguage->visible = true;
        $this->pageLanguage->active = true;
        $this->pageLanguage->language_id = request('language_id') ?? Language::first()->id;
        $this->pageLanguage->target_type = TargetTypeEnum::CONTENT;
//        $this->pageLanguage->layout_id = Layout::first()->id;

        if (request('page_id') && Page::find(request('page_id'))->exists()) {
            $this->pageLanguage->page_id = (int) request('page_id');
            $otherLanguage = PageLanguage::where('page_id', $this->pageLanguage->page_id)->first();
            if (! empty($otherLanguage)) {
                $this->pageLanguage->name = $otherLanguage->name;
                $this->pageLanguage->title = $otherLanguage->title;
                $this->pageLanguage->target_type = $otherLanguage->target_type;
                $this->pageLanguage->url = $otherLanguage->url;
                $this->pageLanguage->layout_id = $otherLanguage->layout_id;
                $this->pageLanguage->visible = $otherLanguage->visible;
                $this->pageLanguage->active = $otherLanguage->active;
            }
        }
    }

    public function grids(): array
    {
        $isUpdate = false;
        $hideParent = ! empty($this->pageLanguage->page_id);

        return app(PageLanguageFormGrid::class)($isUpdate, $hideParent);
    }

    public function rules(): array
    {
        return PageLanguageRules::getRules();
    }

    public function updatedPageLanguageName(): void
    {
        $this->generateTitle();
        $this->generateUrl();
    }

    public function validateUrl()
    {
        $this->validateOnly('pageLanguage.url', [
            'pageLanguage.url' => Rule::unique('page_languages', 'url')->where(function ($query) {
                return $query->where('language_id', $this->pageLanguage->language_id)
                    ->where('target_type', 'content');
            }),
        ]);
    }

    public function create(PageLanguageCreateAction $pageCreateAction): Redirector
    {
        $this->validate();
        $this->validateUrl();
        $pageLanguageData = PageLanguageData::fromModel($this->pageLanguage);
        $pageData = PageData::fromModel($this->page);
        $this->pageLanguage = $pageCreateAction($pageLanguageData, $pageData);
        PageCreated::dispatch();
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('page.list'));
    }

    protected function getValidationAttributes()
    {
        return PageLanguageFieldEnum::labels();
    }

    private function generateTitle(): void
    {
        if (! empty($this->pageLanguage->title) || empty($this->pageLanguage->name)) {
            return;
        }
        $this->pageLanguage->title = $this->pageLanguage->name;
    }

    private function generateUrl(): void
    {
        if (! empty($this->pageLanguage->url) || empty($this->pageLanguage->name)) {
            return;
        }

        $this->pageLanguage->url = Str::of($this->pageLanguage->name)->slug()->prepend('/');
    }
}

<?php

namespace App\Livewire\Domain\Pages\Edit;

use App\Livewire\Base\Form;
use App\Pages\Events\PageUpdated;
use Domain\Pages\Actions\PageLanguageDeleteAction;
use Domain\Pages\Actions\PageLanguageUpdateAction;
use Domain\Pages\DataTransferObjects\PageLanguageData;
use Domain\Pages\FieldEnums\PageLanguageFieldEnum;
use Domain\Pages\FormGrids\PageLanguageFormGrid;
use Domain\Pages\Models\PageLanguage;
use Domain\Pages\Rules\PageLanguageEditRules;
use Illuminate\Validation\Rule;
use Livewire\Redirector;

class PageEdit extends Form
{
    public string $name = 'pageLanguage';

    public PageLanguage $pageLanguage;

    public ?string $listRouteRedirect = 'pages';

    public function mount(PageLanguage $model): void
    {
        $this->pageLanguage = $model;
    }

    public function grids(): array
    {
        return app(PageLanguageFormGrid::class)(true);
    }

    public function rules(): array
    {
        return PageLanguageEditRules::getRules();
    }

    public function validateUrl()
    {
        $this->validateOnly('pageLanguage.url', [
            'pageLanguage.url' => Rule::unique('page_languages', 'url')->where(function ($query) {
                return $query->where('language_id', $this->pageLanguage->language_id)
                    ->where('target_type', 'content');
            })->ignore($this->pageLanguage->id),
        ]);
    }

    public function update(PageLanguageUpdateAction $pageUpdateAction): Redirector
    {
        $this->validate();
        $pageLanguageData = PageLanguageData::fromModel($this->pageLanguage);
        $this->pageLanguage = $pageUpdateAction($this->pageLanguage, $pageLanguageData);
        PageUpdated::dispatch();
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('page.list'));
    }

    protected function validationAttributes(): array
    {
        return PageLanguageFieldEnum::labels();
    }

    public function delete(PageLanguageDeleteAction $pageDeleteAction): Redirector
    {
        $pageDeleteAction($this->pageLanguage);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to($this->listRouteRedirect);
    }
}

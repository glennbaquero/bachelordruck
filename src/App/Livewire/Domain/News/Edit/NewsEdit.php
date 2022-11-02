<?php

namespace App\Livewire\Domain\News\Edit;

use App\Livewire\Base\Form;
use Domain\News\Actions\NewsDeleteAction;
use Domain\News\Actions\NewsUpdateAction;
use Domain\News\DataTransferObjects\NewsData;
use Domain\News\FieldEnums\NewsFieldEnum;
use Domain\News\FormGrids\NewsFormGrid;
use Domain\News\Models\News;
use Domain\News\Rules\NewsRules;
use Illuminate\Validation\Rule;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class NewsEdit extends Form
{
    use withMedia;

    public $mediaComponentNames = ['image', 'images', 'pdf'];

    public $uploadModel;

    public $image;

    public $pdf;

    public $images;

    public string $name = 'news';

    public News $news;

    public function mount(News $model)
    {
        $this->news = $model;
        $this->uploadModel = $this->news;
    }

    public function grids(): array
    {
        return app(NewsFormGrid::class)();
    }

    public function rules(): array
    {
        return NewsRules::getRules($this->news);
    }

    protected function validationAttributes(): array
    {
        return NewsFieldEnum::labels();
    }

    public function delete(NewsDeleteAction $newsDeleteAction): Redirector
    {
        $newsDeleteAction($this->news);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('news.list'));
    }

    protected function validateSlug()
    {
        $this->validateOnly('news.slug', [
            'news.slug' => Rule::unique('news', 'slug')->where(function ($query) {
                return $query->where('language_id', $this->news->language_id);
            })->ignore($this->news->id),
        ]);
    }

    public function update(NewsUpdateAction $newsUpdateAction): Redirector
    {
        $this->validateSlug();
        $this->validate();
        $newsData = NewsData::fromModel($this->news);
        $this->news = $newsUpdateAction($this->news, $newsData);
        $this->news->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        $this->news->syncFromMediaLibraryRequest($this->pdf)->toMediaCollection('pdf');
        $this->news->syncFromMediaLibraryRequest($this->images)->toMediaCollection('images');

        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('news.list'));
    }
}

<?php

namespace App\Livewire\Domain\News\Create;

use App\Enums\StatusEnum;
use App\Livewire\Base\Form;
use Carbon\Carbon;
use Domain\News\Actions\NewsCreateAction;
use Domain\News\DataTransferObjects\NewsData;
use Domain\News\FieldEnums\NewsFieldEnum;
use Domain\News\FormGrids\NewsFormGrid;
use Domain\News\Models\News;
use Domain\News\Rules\NewsRules;
use Domain\Pages\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class NewsCreate extends Form
{
    use withMedia;

    public $mediaComponentNames = ['image', 'images', 'pdf'];

    public $uploadModel;

    public $image;

    public $pdf;

    public $images;

    public string $name = 'news';

    public News   $news;

    public string $method = 'create';

    public function mount(): void
    {
        $date = new Carbon('now');

        $this->news = new News();
        $this->news->language_id = Language::first()->id;
        $this->news->news_date = $date->format('Y-m-d');
        $this->news->status = StatusEnum::DRAFT->value;

        $this->uploadModel = $this->news;
    }

    public function grids(): array
    {
        return app(NewsFormGrid::class)();
    }

    public function updatedNewsTitle(): void
    {
        $this->generateSlug();
    }

    public function rules(): array
    {
        return NewsRules::getRules();
    }

    protected function validateSlug()
    {
        $this->validateOnly('news.slug', [
            'news.slug' => Rule::unique('news', 'slug')->where(function ($query) {
                return $query->where('language_id', $this->news->language_id);
            }),
        ]);
    }

    public function create(NewsCreateAction $newsCreateAction): Redirector
    {
        $this->validateSlug();
        $this->validate();
        $newsData = NewsData::fromModel($this->news);
        $this->news = $newsCreateAction($newsData);

        if ($this->image) {
            $this->news->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        }

        if ($this->pdf) {
            $this->news->addFromMediaLibraryRequest($this->pdf)->toMediaCollection('pdf');
        }

        if ($this->images) {
            $this->news->addFromMediaLibraryRequest($this->images)->toMediaCollection('images');
        }

        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('news.list'));
    }

    protected function validationAttributes(): array
    {
        return NewsFieldEnum::labels();
    }

    private function generateSlug(): void
    {
        if (! empty($this->news->slug) || empty($this->news->title)) {
            return;
        }

        $this->news->slug = Str::of($this->news->title)->slug();
    }
}

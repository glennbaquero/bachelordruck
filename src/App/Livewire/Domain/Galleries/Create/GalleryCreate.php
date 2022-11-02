<?php

namespace App\Livewire\Domain\Galleries\Create;

use App\Livewire\Base\Form;
use Domain\Galleries\Actions\GalleryCreateAction;
use Domain\Galleries\DataTransferObjects\GalleryData;
use Domain\Galleries\FieldEnums\GalleryFieldEnum;
use Domain\Galleries\FormGrids\GalleryFormGrid;
use Domain\Galleries\Models\Gallery;
use Domain\Galleries\Rules\GalleryRules;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class GalleryCreate extends Form
{
    use withMedia;

    public $mediaComponentNames = ['image', 'images', 'pdf'];

    public $uploadModel;

    public $image;

    public $images;

    public $pdf;

    public string $name = 'gallery';

    public Gallery   $gallery;

    public string $method = 'create';

    public bool $refresh = true;

    public function mount(): void
    {
        $this->gallery = new Gallery();
        $this->uploadModel = $this->gallery;
    }

    public function grids(): array
    {
        return app(GalleryFormGrid::class)();
    }

    public function updatedGalleryTitle()
    {
        $this->generateSlug();
    }

    public function rules(): array
    {
        return GalleryRules::getRules();
    }

    protected function validationAttributes(): array
    {
        return GalleryFieldEnum::labels();
    }

    protected function createGallery($galleryCreateAction): void
    {
        $this->validateSlug();
        $this->validate();
        $galleryData = GalleryData::fromModel($this->gallery);
        $this->gallery = $galleryCreateAction($galleryData);

        $this->gallery->syncFromMediaLibraryRequest($this->image)->withCustomProperties('description')->toMediaCollection('image');
        $this->gallery->syncFromMediaLibraryRequest($this->images)->withCustomProperties('description')->toMediaCollection('images');
        $this->gallery->syncFromMediaLibraryRequest($this->pdf)->toMediaCollection('pdf');
    }

    public function create(GalleryCreateAction $galleryCreateAction): Redirector
    {
        $this->createGallery($galleryCreateAction);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('gallery.list'));
    }

    public function refresh(GalleryCreateAction $galleryCreateAction): Redirector
    {
        $this->createGallery($galleryCreateAction);
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('gallery.edit', ['model' => $this->gallery->id]));
    }

    protected function generateSlug(): void
    {
        if (! empty($this->gallery->slug) || empty($this->gallery->title)) {
            return;
        }

        $this->gallery->slug = Str::of($this->gallery->title)->slug();
    }

    protected function validateSlug()
    {
        $this->validateOnly('gallery.slug', [
            'gallery.slug' => Rule::unique('galleries', 'slug')->where(function ($query) {
                return $query->where('language_id', $this->gallery->language_id);
            }),
        ]);
    }
}

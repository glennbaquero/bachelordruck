<?php

namespace App\Livewire\Domain\Galleries\Edit;

use App\Livewire\Base\Form;
use Domain\Galleries\Actions\GalleryDeleteAction;
use Domain\Galleries\Actions\GalleryUpdateAction;
use Domain\Galleries\DataTransferObjects\GalleryData;
use Domain\Galleries\FieldEnums\GalleryFieldEnum;
use Domain\Galleries\FormGrids\GalleryFormGrid;
use Domain\Galleries\Models\Gallery;
use Domain\Galleries\Rules\GalleryRules;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class GalleryEdit extends Form
{
    use withMedia;

    public $mediaComponentNames = ['image', 'images', 'pdf'];

    public $uploadModel;

    public $image;

    public $images;

    public $pdf;

    public string $name = 'gallery';

    public Gallery $gallery;

    public function mount(Gallery $model)
    {
        $this->gallery = $model;
        $this->uploadModel = $this->gallery;
    }

    public function grids(): array
    {
        return app(GalleryFormGrid::class)();
    }

    public function rules(): array
    {
        return GalleryRules::getRules();
    }

    protected function validationAttributes(): array
    {
        return GalleryFieldEnum::labels();
    }

    public function updatedGalleryTitle()
    {
        $this->generateSlug();
    }

    public function update(GalleryUpdateAction $galleryUpdateAction): Redirector
    {
        $this->validateSlug();
        $this->validate();
        $galleryData = GalleryData::fromModel($this->gallery);
        $this->gallery = $galleryUpdateAction($this->gallery, $galleryData);

        $this->gallery->syncFromMediaLibraryRequest($this->image)->withCustomProperties('description')->toMediaCollection('image');
        $this->gallery->syncFromMediaLibraryRequest($this->images)->withCustomProperties('description')->toMediaCollection('images');
        $this->gallery->syncFromMediaLibraryRequest($this->pdf)->toMediaCollection('pdf');

        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('gallery.list'));
    }

    public function delete(GalleryDeleteAction $galleryDeleteAction): Redirector
    {
        $galleryDeleteAction($this->gallery);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('gallery.list'));
    }

    protected function validateSlug()
    {
        $this->validateOnly('gallery.slug', [
            'gallery.slug' => Rule::unique('galleries', 'slug')->where(function ($query) {
                return $query->where('language_id', $this->gallery->language_id);
            })->ignore($this->gallery->id),
        ]);
    }

    protected function generateSlug(): void
    {
        if (! empty($this->gallery->slug) || empty($this->gallery->title)) {
            return;
        }

        $this->gallery->slug = Str::of($this->gallery->title)->slug();
    }
}

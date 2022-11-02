<?php

namespace App\Livewire\Domain\Banners\Edit;

use App\Livewire\Base\Form;
use Domain\Banners\Actions\BannerDeleteAction;
use Domain\Banners\Actions\BannerUpdateAction;
use Domain\Banners\DataTransferObjects\BannerData;
use Domain\Banners\FieldEnums\BannerFieldEnum;
use Domain\Banners\FormGrids\BannerFormGrid;
use Domain\Banners\Models\Banner;
use Domain\Banners\Rules\BannerRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class BannerEdit extends Form
{
    use WithMedia;

    public string   $name = 'banner';

    public Banner     $banner;

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(Banner $model): void
    {
        $this->banner = $model;
        $this->uploadModel = $this->banner;
    }

    public function grids(): array
    {
        return app(BannerFormGrid::class)();
    }

    public function rules(): array
    {
        return BannerRules::getRules($this->banner);
    }

    public function update(BannerUpdateAction $bannerUpdateAction): Redirector
    {
        $this->validate();
        $bannerData = BannerData::fromModel($this->banner);
        $this->banner = $bannerUpdateAction($this->banner, $bannerData);
        $this->banner->syncFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('banner.list'));
    }

    public function delete(BannerDeleteAction $bannerDeleteAction): Redirector
    {
        $bannerDeleteAction($this->banner);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('banner.list'));
    }

    protected function validationAttributes(): array
    {
        return BannerFieldEnum::labels();
    }

    public function clearAvatar()
    {
        $this->uploadModel->clearMediaCollection('image');
    }
}

<?php

namespace App\Livewire\Domain\Banners\Create;

use App\Livewire\Base\Form;
use Domain\Banners\Actions\BannerCreateAction;
use Domain\Banners\DataTransferObjects\BannerData;
use Domain\Banners\FieldEnums\BannerFieldEnum;
use Domain\Banners\FormGrids\BannerFormGrid;
use Domain\Banners\Models\Banner;
use Domain\Banners\Rules\BannerRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class BannerCreate extends Form
{
    use WithMedia;

    public string $name = 'banner';

    public Banner   $banner;

    public string $method = 'create';

    public $mediaComponentNames = ['image'];

    public $uploadModel;

    public $image;

    public function mount(): void
    {
        $this->banner = new Banner();
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

    public function create(BannerCreateAction $bannerCreateAction): Redirector
    {
        $this->validate();
        $bannerData = BannerData::fromModel($this->banner);
        $this->banner = $bannerCreateAction($bannerData);
        $this->banner->addFromMediaLibraryRequest($this->image)->toMediaCollection('image');
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('banner.list'));
    }

    protected function validationAttributes(): array
    {
        return BannerFieldEnum::labels();
    }

    public function clearAvatar()
    {
        $this->imageModel->clearMediaCollection('image');
    }
}

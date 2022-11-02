<?php

namespace App\Livewire\Domain\Users\Create;

use App\Livewire\Base\Form;
use App\Livewire\Traits\WithAvatar;
use Domain\Users\Actions\UserCreateAction;
use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\FieldEnums\UserFieldEnum;
use Domain\Users\FormGrids\UserFormGrid;
use Domain\Users\Models\User;
use Domain\Users\Rules\UserRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Support\Helpers\NameHelpers;

class UserCreate extends Form
{
    use WithMedia;
    use WithAvatar;

    public string $name = 'user';

    public User   $user;

    public string $method = 'create';

    public $mediaComponentNames = ['avatar'];

    public $avatar;

    public function mount(): void
    {
        $this->user = new User();
        $this->avatarModel = $this->user;
    }

    public function grids(): array
    {
        return app(UserFormGrid::class)();
    }

    public function rules(): array
    {
        return UserRules::getRules($this->user);
    }

    public function updatedUserName($value): void
    {
        $this->generateInitials();
    }

    public function create(UserCreateAction $userCreateAction): Redirector
    {
        $this->generateInitials();
        $this->validate();
        $userData = UserData::fromModel($this->user);
        $this->user = $userCreateAction($userData);
        $this->user->addFromMediaLibraryRequest($this->avatar)->toMediaCollection('avatars');
        session()->flash('message', __('notification.create_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('user.list'));
    }

    protected function generateInitials(): void
    {
        if (! empty($this->user->initials) || empty($this->user->name)) {
            return;
        }

        $this->user->initials = NameHelpers::getInitials($this->user->name);
    }

    protected function validationAttributes(): array
    {
        return UserFieldEnum::labels();
    }
}

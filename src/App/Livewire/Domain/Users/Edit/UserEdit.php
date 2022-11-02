<?php

namespace App\Livewire\Domain\Users\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Traits\WithAvatar;
use Domain\Users\Actions\UserDeleteAction;
use Domain\Users\Actions\UserUpdateAction;
use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\FieldEnums\UserFieldEnum;
use Domain\Users\FormGrids\UserFormGrid;
use Domain\Users\Models\User;
use Domain\Users\Rules\UserRules;
use Livewire\Redirector;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Support\Helpers\NameHelpers;

class UserEdit extends Form
{
    use WithMedia;
    use WithAvatar;

    public string   $name = 'user';

    public User     $user;

    public function mount(User $model): void
    {
        $this->user = $model;
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

    public function update(UserUpdateAction $userUpdateAction): Redirector
    {
        $this->generateInitials();
        $this->validate();
        $userData = UserData::fromModel($this->user);
        $this->user = $userUpdateAction($this->user, $userData);
        if ($this->avatar) {
            $this->user->clearMediaCollection('avatars');
            $this->user->addFromMediaLibraryRequest($this->avatar)->toMediaCollection('avatars');
        }
        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('user.list'));
    }

    public function delete(UserDeleteAction $userDeleteAction): Redirector
    {
        $userDeleteAction($this->user);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

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

<?php

namespace App\Livewire\Domain\Users\Edit;

use App\Livewire\Base\Form;
use Domain\Users\Actions\UserChangePasswordAction;
use Domain\Users\FormGrids\UserChangePasswordFormGrid;
use Domain\Users\Models\User;
use Domain\Users\Rules\PasswordRules;
use Livewire\Redirector;

class UserChangePassword extends Form
{
    public string   $name = 'user';

    public User     $user;

    public string $method = 'changePassword';

    public function mount(User $model): void
    {
        $this->user = $model;
    }

    public function grids(): array
    {
        return app(UserChangePasswordFormGrid::class)();
    }

    public function rules(): array
    {
        return PasswordRules::getRules();
    }

    public function changePassword(UserChangePasswordAction $action): Redirector
    {
        $this->validate();

        $action($this->user, $this->user->new_password);

        session()->flash('message', __('Password has been changed!'));

        return redirect()->to(route('user.list'));
    }
}

<?php

namespace App\Livewire\Domain\Users\Show;

use App\Livewire\Base\Show;
use Domain\Users\Actions\UserDeleteAction;
use Domain\Users\Models\User;
use Domain\Users\ShowGrids\UserShowGrid;
use Livewire\Redirector;

class UserShow extends Show
{
    public string $name = 'user';

    public User   $model;

    public function mount(User $model): void
    {
        $this->model = $model;
    }

    public function grids(): array
    {
        return app(UserShowGrid::class)();
    }

    public function delete(UserDeleteAction $userDeleteAction): Redirector
    {
        $userDeleteAction($this->model);
        session()->flash('message', __('notification.delete_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('user.list'));
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('user.edit', ['model' => $this->model->id]));
    }
}

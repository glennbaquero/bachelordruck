<?php

namespace App\Livewire\Domain\Users\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Users\Actions\UserDeleteAction;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.users')]);
        $this->createButtonTitle = __('button.create', ['model' => __('model.user')]);
        $this->createRoute = route('user.create');
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/users/%s', $id))
            ),
            Column::user(
                field: 'id',
                label: 'User',
                token: 'user',
            ),
            Column::text(
                field: 'name',
                token: 'user'
            )->sortable(),
            Column::email(
                field: 'email',
                token: 'user'
            )->sortable(),
            Column::color(
                field: 'color',
                token: 'user',
            ),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/users/%s/edit', $id))
            ),
            Column::action(
                action: 'delete'
            )->setCallback(
                function ($id) {
                    $this->currentId = $id;
                    $this->showModalConfirmation = true;
                }
            ),
            Column::action(
                action: 'custom'
            )->setCustomActions([
                [
                    'label' => __('Change Password'),
                    'action' => fn ($id) => redirect(route('user.change_password', ['model' => $id])),
                ],
            ]),
        ];
    }

    public function query(): Builder
    {
        return User::query()->with('media');
    }

    public function delete(UserDeleteAction $userDeleteAction, User $user): void
    {
        if ($user->id === null) {
            $user = User::findOrFail($this->currentId);
        }

        $userDeleteAction($user);
        $this->showModalConfirmation = false;
    }
}

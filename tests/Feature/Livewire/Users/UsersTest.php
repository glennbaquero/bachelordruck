<?php

use App\Livewire\Domain\Users\Create\UserCreate;
use App\Livewire\Domain\Users\Edit\UserEdit;
use App\Livewire\Domain\Users\Lists\UsersList;
use App\Livewire\Domain\Users\Show\UserShow;
use Domain\Users\Models\User;
use function Pest\Livewire\livewire;

beforeEach(function () {
    config()->set('app.faker_locale', 'en_US');
});

it('loads users list', function () {
    $this->webActingAs();

    $this->get(route('user.list'))
        ->assertOk()
        ->assertSeeLivewire(UsersList::class);
});

it('displays list of users', function () {
    $users = User::factory()->count(20)->create();
    $component = livewire(UsersList::class);

    expect($component->get('createRoute'))
        ->toBe(route('user.create'));

    expect($component->get('rows'))
        ->toHaveCount($component->get('perPage'));

    $component->assertSee([]);

    $component->assertSee(
        $users
        ->pluck('name') // Change this to a field/column being displayed
        ->splice(0, 10)
        ->all()
    );
});

it('load create user route', function () {
    $this->webActingAs();

    $this->get(route('user.create'))
        ->assertOk()
        ->assertSeeLivewire(UserCreate::class);
});

it('create a user', function () {
    $this->webActingAs();

    $user = User::factory()->make();

    livewire(UserCreate::class)
        ->set('user.name', $user->name)
        ->set('user.email', $user->email)
        ->call('create')
        ->assertRedirect(route('user.list'))
        ->assertSessionHas('message');

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

it('shows user', function () {
    $this->webActingAs();

    $user = User::factory()->create();

    $this->get(route('user.show', ['model' => $user->id]))
        ->assertOk()
        ->assertSeeLivewire(UserShow::class)
        ->assertSee([
            'Name',
            'E-Mail',
        ])
        ->assertSee([
            $user->name,
            $user->email,
        ]);
});

it('load user route', function () {
    $this->webActingAs();

    $user = User::factory()->create();

    $this->get(route('user.edit', ['model' => $user->id]))
        ->assertOk()
        ->assertSeeLivewire(UserEdit::class)
        ->assertSee([
            'name',
            'email',
        ])
        ->assertSee([
            $user->name,
            $user->email,
        ]);
});

it('update user', function () {
    $user = User::factory()->create([
        'name' => 'User Name',
    ]);

    livewire(UserEdit::class, ['model' => $user->id])
        ->set('user.name', 'New Name')
        ->call('update')
        ->assertRedirect(route('user.list'))
        ->assertSessionHas('message');

    $user->refresh();

    expect($user)
        ->name->toEqual('New Name');
});

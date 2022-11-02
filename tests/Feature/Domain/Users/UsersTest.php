<?php

namespace Tests\Feature\Domain\Users;

use Domain\Users\Actions\UserChangePasswordAction;
use Domain\Users\Actions\UserCreateAction;
use Domain\Users\Actions\UserDeleteAction;
use Domain\Users\Actions\UserUpdateAction;
use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\FieldEnums\UserFieldEnum;
use Domain\Users\Models\User;
use Domain\Users\Rules\UserRules;
use Illuminate\Support\Facades\Hash;

test('create user data from model', function () {
    $user = User::factory()->make();

    $data = UserData::fromModel($user);

    expect($data)
        ->name->toEqual($user->name);
});

test('user create action', function () {
    $user = User::factory()->make();

    $data = UserData::fromModel($user);

    app(UserCreateAction::class)($data);

    $this->assertDatabaseHas('users', $data->toArray());
});

test('user update action', function () {
    $user = User::factory()->create([
        'initials' => '',
    ]);

    $data = UserData::fromModel($user);

    $newFieldValue = 'Test Edit';

    $data->name = $newFieldValue;

    app(UserUpdateAction::class)($user, $data);

    $user->refresh();

    expect($user)
        ->name->toEqual($newFieldValue);
});

test('user delete action', function () {
    $user = User::factory()->create();

    app(UserDeleteAction::class)($user);

    $this->assertModelMissing($user);
});

test('user field enum labels', function () {
    app()->setLocale('en');

    expect(UserFieldEnum::labels())->toBe([
        'id' => 'Id',
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'initials' => 'Initials',
        'color' => 'Color',
        'avatar' => 'Avatar',
    ]);
});

test('user rules key is prepended', function () {
    expect(array_keys(UserRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('user.');
});

test('user change password action', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $user->new_password = 'new_password';

    app(UserChangePasswordAction::class)($user, $user->new_password);

    $user->refresh();

    $this->assertTrue(Hash::check('new_password', $user->password));
});

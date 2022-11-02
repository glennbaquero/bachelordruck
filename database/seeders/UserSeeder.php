<?php

namespace Database\Seeders;

use Domain\Users\Actions\UserCreateAction;
use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::query()->count() !== 0) {
            return;
        }

        $userdata = new UserData(name: 'Mike', email: 'ms@aranes.de', password: Hash::make('test12'), initials: 'MS');
        app(UserCreateAction::class)($userdata);
    }
}

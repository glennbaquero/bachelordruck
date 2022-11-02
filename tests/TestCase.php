<?php

namespace Tests;

use Database\Seeders\LanguageSeeder;
use Database\Seeders\LayoutSeeder;
use Database\Seeders\PageSeeder;
use Domain\Users\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery\MockInterface;
use Support\Translator\Interfaces\TranslatorInterface;
use Support\Translator\Services\DeeplTranslatorService;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        /*
        | Improve the performance when executing tests. When an env `MIGRATED` variable is set to `true`
        | it will not refresh the database nor run the migration files, it will directly run the tests resulting to
        | a much faster test results.
        |
        | If there are changes in the migration files,  the `MIGRATED` env variable must be set to `false` in order to
        | apply and migrate the changes in database structure.
        |
        | This is how to set `MIGRATED` when running tests:
        |   - MIGRATED=0 vendor/bin/pest  # refresh the database then run tests
        |   - MIGRATED=1 vendor/bin/pest  # run the tests without refreshing the database
        |
        | It is also recommended that an alias will be created in the .bash_rc file for better test experience.
        |   - alias tm='MIGRATED=1 vendor/bin/pest'
        |   - alias tr='MIGRATED=0 vendor/bin/pest'
        */

        if (! RefreshDatabaseState::$migrated) {
            RefreshDatabaseState::$migrated = (bool) env('MIGRATED');
        }

        parent::setUp();

        config()->set('app.faker_locale', 'en_US');

        $this->seed(LayoutSeeder::class);
        $this->seed(LanguageSeeder::class);
        $this->seed(PageSeeder::class);
    }

    public function webActingAs(?User $user = null): Authenticatable
    {
        if (! $user) {
            $user = User::first() ?? User::factory()->create();
        }

        $this->actingAs($user);

        return $user;
    }

    public function mockTranslator(string|array $returnValue): void
    {
        config()->set('translator.service_class', DeeplTranslatorService::class);

        $this->mock(TranslatorInterface::class, function (MockInterface $mock) use ($returnValue) {
            $mock->shouldReceive('from')
                ->withArgs(fn ($arg) => true)
                ->andReturnSelf();

            $mock->shouldReceive('translate')
                ->withArgs(fn ($arg1, $arg2) => true)
                ->andReturns($returnValue);
        });
    }
}

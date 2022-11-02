<?php

namespace Database\Seeders;

use Domain\Pages\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Language::query()->count() !== 0) {
            return;
        }

        Language::unguard();

        Language::create(['id' => 1, 'languageCode' => 'de', 'title' => 'Deutsch']);
        Language::create(['id' => 2, 'languageCode' => 'en', 'title' => 'English']);

        Language::reguard();
    }
}

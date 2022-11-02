<?php

namespace Database\Factories;

use Domain\Pages\Models\Language;
use Domain\Pages\Models\Layout;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageLanguage::class;

    public function definition(): array
    {
        return [
            'page_id' => null,
            'language_id' => Language::query()->first(),
            'url' => '/'.$this->faker->unique()->word,
            'target_type' => 'content',
            'name' => $name = $this->faker->word,
            'title' => $name,
            'layout_id' => Layout::query()->first(),
            'description' => $this->faker->words(3, true),
            'active' => 1,
            'visible' => 1,
        ];
    }
}

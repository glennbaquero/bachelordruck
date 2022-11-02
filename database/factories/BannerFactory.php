<?php

namespace Database\Factories;

use Domain\Banners\Models\Banner;
use Domain\Pages\Models\Language;
use Domain\Pages\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'page_id' => Page::query()->first(),
            'language_id' => Language::query()->first(),
            'transmission' => true,
            'title' => $this->faker->words(2, true),
            'description' => $this->faker->words(3, true),
            'url' => $this->faker->url(),
            'link_text' => $this->faker->word,
            'sort' => 1,
            'status' => 'active',
        ];
    }
}

<?php

namespace Database\Factories;

use Domain\Galleries\Models\Gallery;
use Domain\Pages\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gallery::class;

    public function definition(): array
    {
        return [
            'language_id' => Language::query()->first(),
            'title' => $title = $this->faker->words(2, true),
            'slug' => Str::slug($title),
            'description' => $this->faker->words(3, true),
            'status' => 'active',
            'sort' => 1,
        ];
    }
}

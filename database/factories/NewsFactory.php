<?php

namespace Database\Factories;

use Domain\News\Models\News;
use Domain\Pages\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'language_id' => Language::query()->first(),
            'title' => $title = $this->faker->unique()->words(2, true),
            'slug' => Str::slug($title),
            'description' => $this->faker->words(3, true),
            'video_url' => $this->faker->url(),
            'news_date' => $this->faker->date,
            'status' => 'active',
        ];
    }
}

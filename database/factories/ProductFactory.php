<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->unique()->word(),
            'slug' => Str::slug($title),
            'tooltip' => $this->faker->word(),
            'description' => $this->faker->words(3, true),
            'price' => $this->faker->randomDigit(),
            'has_cover_color' => false,
            'has_cover_imprint_color' => false,
            'has_cover_foil' => false,
            'has_back_cover' => false,
            'has_book_spine_label' => false,
            'book_spine_label_surcharge' => $this->faker->randomDigit(),
            'has_book_corners' => false,
            'book_corners_surcharge' => $this->faker->randomDigit(),
            'has_ribbon' => false,
            'ribbon_surcharge' => $this->faker->randomDigit(),
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

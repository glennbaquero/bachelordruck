<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductPaperThickness;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPaperThicknessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPaperThickness::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'title' => $this->faker->word(),
            'tooltip' => $this->faker->word(),
            'max_pages' => $this->faker->randomDigit(),
            'price_per_page_bw' => $this->faker->randomDigit(),
            'price_per_page_color' => $this->faker->randomDigit(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

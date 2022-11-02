<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductBookSpineColor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductBookSpineColorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductBookSpineColor::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'title' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

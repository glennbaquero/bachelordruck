<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\Product;
use Domain\Products\Models\ProductFormat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFormatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductFormat::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'title' => $this->faker->word(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

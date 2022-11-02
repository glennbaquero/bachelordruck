<?php

namespace Database\Factories;

use Domain\Orders\Models\BasketPosition;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BasketPositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BasketPosition::class;

    public function definition(): array
    {
        return [
            'session_id' => Str::random(40),
            'product_id' => Product::factory(),
            'qty' => $this->faker->randomDigit(),
            'configuration' => [],
            'price' => $this->faker->randomDigit(),
        ];
    }
}

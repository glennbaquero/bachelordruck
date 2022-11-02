<?php

namespace Database\Factories;

use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderPosition;
use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderPosition::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'qty' => $this->faker->randomDigit(),
            'configuration' => [],
            'product_data' => [],
            'price' => $this->faker->randomDigit(),
        ];
    }
}

<?php

namespace Database\Factories;

use Domain\Products\Models\ProductCoverImprintColor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCoverImprintColorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCoverImprintColor::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => 'active',
        ];
    }
}

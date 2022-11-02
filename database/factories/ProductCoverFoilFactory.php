<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductCoverFoil;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCoverFoilFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCoverFoil::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

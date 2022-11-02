<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\ProductBackCover;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductBackCoverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductBackCover::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'is_preselected' => false,
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

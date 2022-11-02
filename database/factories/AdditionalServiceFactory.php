<?php

namespace Database\Factories;

use Domain\Products\Enums\StatusEnum;
use Domain\Products\Models\AdditionalService;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdditionalService::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'tooltip' => $this->faker->word(),
            'surcharge' => $this->faker->randomDigit(),
            'sort' => 1,
            'status' => StatusEnum::ACTIVE->value,
        ];
    }
}

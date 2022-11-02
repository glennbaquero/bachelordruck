<?php

namespace Database\Factories;

use Domain\Containers\Enums\ContainerTypeEnum;
use Domain\Containers\Models\Container;
use Domain\Pages\Enums\ImageAlignmentEnum;
use Domain\Pages\Models\PageLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Container::class;

    public function definition(): array
    {
        return [
            'sort' => 1,
            'title' => $this->faker->word,
            'image_alignment' => $this->faker->randomElement(
                collect(ImageAlignmentEnum::cases())
                    ->map(fn ($alignment) => $alignment->value)
                    ->toArray()
            ),
            'content' => $this->faker->words(3, true),
            'type' => $this->faker->randomElement(
                collect(ContainerTypeEnum::cases())
                    ->map(fn ($containerType) => $containerType->value)
                    ->toArray()
            ),
            'pages_language_id' => PageLanguage::first(),
            'url' => $this->faker->url,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Enums\SalutationEnum;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'session_id' => Str::random(40),
            'customer_type' => $this->faker->randomElement(
                collect(CustomerTypeEnum::cases())
                    ->map(fn ($customerType) => $customerType->value)
                    ->toArray()
            ),
            'title' => SalutationEnum::MR->value,
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->freeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'street' => $this->faker->streetAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),

            'is_recipient_different' => true,

            'recipient_title' => SalutationEnum::MR->value,
            'recipient_firstname' => $this->faker->firstName(),
            'recipient_lastname' => $this->faker->lastName(),
            'recipient_street' => $this->faker->streetAddress(),
            'recipient_postal_code' => $this->faker->postcode(),
            'recipient_city' => $this->faker->city(),

            'total_amount' => $this->faker->randomDigit(),
            'payment' => PaymentEnum::CASH->value,
            'status' => StatusEnum::FINISHED->value,
        ];
    }
}

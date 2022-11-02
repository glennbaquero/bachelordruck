<?php

namespace Database\Factories;

use Domain\Orders\Enums\IntentEnum;
use Domain\Orders\Enums\PaymentStatusEnum;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderPayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'reference' => Str::random(17),
            'intent' => IntentEnum::CAPTURE->value,
            'status' => PaymentStatusEnum::COMPLETED->value,
            'response' => [],
        ];
    }
}

<?php

namespace Tests\Feature\Domain\Orders;

use Database\Seeders\UserSeeder;
use Domain\Orders\Actions\OrderStatusUpdateAction;
use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;
use Domain\Users\Models\User;
use function Pest\Laravel\seed;

test('order status update action', function () {
    $order = Order::factory()->create();

    $data = OrderData::fromModel($order);

    $newStatus = StatusEnum::IN_PRODUCTION;

    $data->status = $newStatus;

    app(OrderStatusUpdateAction::class)($order, $data);

    $order->refresh();

    expect($order)
        ->status->toEqual($newStatus);
});

test('order show', function () {
    seed([
        UserSeeder::class,
    ]);

    $user = User::first();
    $this->actingAs($user);

    $order = Order::factory()->create();

    $this->followingRedirects()
        ->get("orders/$order->id")
        ->assertSee([
            $order->firstname,
            $order->lastname,
            $order->email,
            $order->phone,
            $order->street,
            $order->postal_code,
            $order->city,
        ]);
});

test('order edit', function () {
    seed([
        UserSeeder::class,
    ]);

    $user = User::first();
    $this->actingAs($user);

    $order = Order::factory()->create();

    $this->followingRedirects()
        ->get("orders/$order->id/edit")
        ->assertSee([
            $order->firstname,
            $order->lastname,
            $order->email,
            $order->phone,
            $order->street,
            $order->postal_code,
            $order->city,
        ]);
});

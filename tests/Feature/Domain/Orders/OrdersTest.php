<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\OrderCompleteAction;
use Domain\Orders\Actions\OrderCreateAction;
use Domain\Orders\Actions\OrderDeleteAction;
use Domain\Orders\Actions\OrderUpdateAction;
use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\FieldEnums\OrderFieldEnum;
use Domain\Orders\Models\Order;
use Domain\Orders\Rules\OrderRules;

test('create order data from model', function () {
    /** @var Order $order */
    $order = Order::factory()->make();

    $data = OrderData::fromModel($order);

    expect($data)
        ->session_id->toEqual($order->session_id)
        ->customer_type->toEqual($order->customer_type)
        ->title->toEqual($order->title)
        ->firstname->toEqual($order->firstname)
        ->lastname->toEqual($order->lastname)
        ->email->toEqual($order->email)
        ->phone->toEqual($order->phone)
        ->street->toEqual($order->street)
        ->postal_code->toEqual($order->postal_code)
        ->city->toEqual($order->city)
        ->is_recipient_different->toEqual($order->is_recipient_different)
        ->recipient_firstname->toEqual($order->recipient_firstname)
        ->recipient_lastname->toEqual($order->recipient_lastname)
        ->recipient_street->toEqual($order->recipient_street)
        ->recipient_postal_code->toEqual($order->recipient_postal_code)
        ->recipient_city->toEqual($order->recipient_city)
        ->total_amount->toEqual($order->total_amount)
        ->payment->toEqual($order->payment)
        ->status->toEqual($order->status);
});

test('order create action', function () {
    /** @var Order $order */
    $order = Order::factory()->make();

    $data = OrderData::fromModel($order);

    app(OrderCreateAction::class)($data);

    $dataArray = $data->toArray();

    $dataArray['total_amount'] *= 100;

    $this->assertDatabaseHas('orders', $dataArray);
});

test('order update action', function () {
    $order = Order::factory()->create();

    $data = OrderData::fromModel($order);

    $newFieldValue = 'Test Edit';

    $data->firstname = $newFieldValue;

    app(OrderUpdateAction::class)($order, $data);

    $order->refresh();

    expect($order)
        ->firstname->toEqual($newFieldValue);
});

test('order delete action', function () {
    $order = Order::factory()->create();

    app(OrderDeleteAction::class)($order);

    $this->assertModelMissing($order);
});

test('order complete action', function () {
    $order = Order::factory()->create();

    app(OrderCompleteAction::class)($order);

    $order->refresh();

    expect($order)
        ->completed_at->not()->toBeNull()
        ->status->toEqual(StatusEnum::READY_FOR_PRODUCTION);
});

test('order field enum labels', function () {
    app()->setLocale('en');

    expect(OrderFieldEnum::labels())->toBe([
        'id' => 'Id',

        'session_id' => 'Session Id',
        'customer_type' => 'Customer Type',
        'title' => 'Title',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'email' => 'E-Mail',
        'phone' => 'Phone',
        'street' => 'Street',
        'postal_code' => 'Postal Code',
        'city' => 'City',

        'is_recipient_different' => 'Is Recipient Different',

        'recipient_title' => 'Recipient Title',
        'recipient_firstname' => 'Recipient Firstname',
        'recipient_lastname' => 'Recipient Lastname',
        'recipient_street' => 'Recipient Street',
        'recipient_postal_code' => 'Recipient Postal Code',
        'recipient_city' => 'Recipient City',

        'total_amount' => 'Total Amount',
        'payment' => 'Payment',
        'status' => 'Status',
    ]);
});

test('order rules key is prepended', function () {
    expect(array_keys(OrderRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('order.');
});

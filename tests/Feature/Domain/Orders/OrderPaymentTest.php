<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\OrderPaymentCreateAction;
use Domain\Orders\DataTransferObjects\OrderPaymentData;
use Domain\Orders\Models\OrderPayment;

test('order payment create action', function () {
    /** @var OrderPayment $orderPayment */
    $orderPayment = OrderPayment::factory()->make();

    $data = OrderPaymentData::fromModel($orderPayment);
    $createdOrderPayment = app(OrderPaymentCreateAction::class)($data);

    $dataArray = $data->toArray();
    unset($dataArray['response']);
    $this->assertDatabaseHas('order_payments', $dataArray);

    expect($createdOrderPayment->response)
        ->toEqual($data->response->all());
});

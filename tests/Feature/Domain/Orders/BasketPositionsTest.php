<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\BasketPositionCreateAction;
use Domain\Orders\Actions\BasketPositionDeleteAction;
use Domain\Orders\Actions\BasketPositionUpdateAction;
use Domain\Orders\DataTransferObjects\BasketPositionData;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Rules\BasketPositionRules;
use Domain\Products\Models\Product;

test('create basketPosition data from model', function () {
    /** @var BasketPosition $basketPosition */
    $basketPosition = BasketPosition::factory()->make([
        'session_id' => session()->getId(),
        'configuration' => [
            'product_id' => Product::factory()->create()->id,
        ],
    ]);

    $productConfigurationData = new ProductConfigurationData($basketPosition->configuration);

    $data = BasketPositionData::fromModel($basketPosition);

    expect($data)
        ->session_id->toEqual(session()->getId())
        ->product_id->toEqual($basketPosition->product_id)
        ->qty->toEqual($basketPosition->qty)
        ->configuration->toEqual($productConfigurationData)
        ->price->toEqual($basketPosition->price);
});

test('basketPosition create action', function () {
    /** @var BasketPosition $basketPosition */
    $basketPosition = BasketPosition::factory()->make([
        'session_id' => session()->getId(),
        'configuration' => [
            'product_id' => Product::factory()->create()->id,
        ],
    ]);

    $data = BasketPositionData::fromModel($basketPosition);

    $createdBasketPosition = app(BasketPositionCreateAction::class)($data);

    $dataArray = $data->toArray();

    unset($dataArray['configuration']);
    $dataArray['price'] *= 100;

    $this->assertDatabaseHas('basket_positions', $dataArray);

    expect($createdBasketPosition->configuration)
        ->toEqual($data->configuration->all());
});

test('basketPosition update action', function () {
    $basketPosition = BasketPosition::factory()->create([
        'session_id' => session()->getId(),
        'configuration' => [
            'product_id' => Product::factory()->create()->id,
        ],
    ]);

    $data = BasketPositionData::fromModel($basketPosition);

    $newFieldValue = 1;

    $data->qty = $newFieldValue;

    app(BasketPositionUpdateAction::class)($basketPosition, $data);

    $basketPosition->refresh();

    expect($basketPosition)
        ->qty->toEqual($newFieldValue)
        ->configuration->toEqual($data->configuration->all());
});

test('basketPosition delete action', function () {
    $basketPosition = BasketPosition::factory()->create();

    app(BasketPositionDeleteAction::class)($basketPosition);

    $this->assertModelMissing($basketPosition);
});

test('basketPosition field enum labels', function () {
    app()->setLocale('en');

    expect(BasketPositionFieldEnum::labels())->toBe([
        // 'id' => 'Id',
    ]);
})->skip();

test('basketPosition rules key is prepended', function () {
    expect(array_keys(BasketPositionRules::getRules()))
        ->each(fn ($key) => $key)
        ->toContain('basketPosition.');
});

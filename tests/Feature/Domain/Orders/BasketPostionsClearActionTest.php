<?php

namespace Tests\Feature\Domain\Orders;

use Domain\Orders\Actions\BasketPositionsClearAction;
use Domain\Orders\Models\BasketPosition;

test('basketPosition created 24 hours ago clear action', function () {
    $basketPosition = BasketPosition::factory()->create();
    $basketPosition->created_at = now()->subHours(24);
    $basketPosition->save();

    app(BasketPositionsClearAction::class)();

    $this->assertModelMissing($basketPosition);
});

test('basketPosition 48 hours ago clear action', function () {
    $basketPosition = BasketPosition::factory()->create();
    $basketPosition->created_at = now()->subHours(48);
    $basketPosition->save();

    app(BasketPositionsClearAction::class)();

    $this->assertModelMissing($basketPosition);
});

test('basketPosition newly created clear action', function () {
    $basketPosition = BasketPosition::factory()->create();

    app(BasketPositionsClearAction::class)();

    $this->assertModelExists($basketPosition);
});

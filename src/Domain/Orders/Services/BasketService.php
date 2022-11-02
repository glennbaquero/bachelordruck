<?php

namespace Domain\Orders\Services;

use Domain\Orders\Actions\BasketPositionCreateAction;
use Domain\Orders\Actions\BasketPositionDeleteAction;
use Domain\Orders\Actions\BasketPositionUpdateAction;
use Domain\Orders\DataTransferObjects\BasketPositionData;
use Domain\Orders\DataTransferObjects\ProductConfigurationData;
use Domain\Orders\Models\BasketPosition;
use Illuminate\Database\Eloquent\Collection;

class BasketService
{
    public function __construct(
        protected string $sessionId
    ) {
    }

    public static function session(string $sessionId): static
    {
        return new static($sessionId);
    }

    public function get(): Collection
    {
        return BasketPosition::query()
            ->with('product')
            ->where('session_id', $this->sessionId)
            ->get();
    }

    public function add(BasketPosition $basketPosition, ProductConfigurationData $productConfigurationData): void
    {
        $basketPosition->session_id = $this->sessionId;
        $basketPosition->configuration = $productConfigurationData->all();

        $data = BasketPositionData::fromModel($basketPosition);

        app(BasketPositionCreateAction::class)($data);
    }

    public function update(BasketPosition $basketPosition, ProductConfigurationData $productConfigurationData): void
    {
        $basketPosition->configuration = $productConfigurationData->all();

        $data = BasketPositionData::fromModel($basketPosition);

        app(BasketPositionUpdateAction::class)($basketPosition, $data);
    }

    public function remove(BasketPosition $basketPosition): void
    {
        app(BasketPositionDeleteAction::class)($basketPosition);
    }

    public function count(): int
    {
        return BasketPosition::query()
            ->with('product')
            ->where('session_id', $this->sessionId)
            ->count();
    }
}

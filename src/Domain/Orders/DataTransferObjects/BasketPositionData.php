<?php

namespace Domain\Orders\DataTransferObjects;

use Domain\Orders\Models\BasketPosition;
use Spatie\DataTransferObject\DataTransferObject;

class BasketPositionData extends DataTransferObject
{
    public string $session_id;

    public int $product_id;

    public int $qty;

    public ProductConfigurationData $configuration;

    public float $price;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        string $session_id,
        int $product_id,
        ProductConfigurationData $configuration,
        float $price,
        int $qty = 1,
    ): BasketPositionData {
        return new self(get_defined_vars());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromModel(BasketPosition $basketPosition): BasketPositionData
    {
        return new self(
            session_id: $basketPosition->session_id,
            product_id: $basketPosition->product_id,
            qty: $basketPosition->qty,
            configuration: new ProductConfigurationData($basketPosition->configuration),
            price: $basketPosition->price,
        );
    }
}

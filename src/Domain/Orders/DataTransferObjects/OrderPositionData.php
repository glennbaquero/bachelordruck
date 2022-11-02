<?php

namespace Domain\Orders\DataTransferObjects;

use Domain\Orders\Models\OrderPosition;
use Domain\Products\DataTransferObjects\ProductData;
use Domain\Products\Models\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderPositionData extends DataTransferObject
{
    public int $order_id;

    public int $product_id;

    public int $qty;

    public ProductConfigurationData $configuration;

    public ProductData $product_data;

    public float $price;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function create(
        int $order_id,
        int $product_id,
        float $price,
        int $qty = 1,
        ProductConfigurationData $configuration = null,
        ProductData $product_data = null,
    ): OrderPositionData {
        return new self(get_defined_vars());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromModel(OrderPosition $orderPosition): OrderPositionData
    {
        $product = new Product($orderPosition->product_data);

        return new self(
            order_id: $orderPosition->order_id,
            product_id: $orderPosition->product_id,
            qty: $orderPosition->qty,
            configuration: new ProductConfigurationData($orderPosition->configuration),
            product_data: ProductData::fromModel($product),
            price: $orderPosition->price,
        );
    }
}

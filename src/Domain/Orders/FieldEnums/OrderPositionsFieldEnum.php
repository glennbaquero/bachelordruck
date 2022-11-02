<?php

namespace Domain\Orders\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum OrderPositionsFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case ORDER_ID = 'order_id';
    case PRODUCT_ID = 'product_id';
    case QTY = 'qty';
    case CONFIGURATION = 'configuration';
    case PRODUCT_DATA = 'product_data';
    case PRICE = 'price';

    public function payload(): array
    {
        return [];
    }
}

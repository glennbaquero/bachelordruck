<?php

namespace Domain\Orders\ShowGrids;

use App\Livewire\View\Fieldset;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\FieldEnums\OrderFieldEnum;
use Domain\Orders\FieldEnums\OrderPositionsFieldEnum;
use Support\Creators\OutputFieldCreator;

class OrderShowGrid
{
    private string $modelName = 'order';

    public function __invoke($orderPositions, $language, $sessionId): array
    {
        $fieldCreator = new OutputFieldCreator($this->modelName);

        $orderPositionsFields = [];

        $orderPositionsFields[] = $fieldCreator->customText(field: 'order_details', value: '');

        foreach ($orderPositions as $orderPosition) {
            $orderPositionsFields[] = $fieldCreator->customText(field: OrderPositionsFieldEnum::PRODUCT_ID, value: $orderPosition->product_data['title']);
            $orderPositionsFields[] = $fieldCreator->customText(field: OrderPositionsFieldEnum::QTY, value: $orderPosition->qty);
            $orderPositionsFields[] = $fieldCreator->customText(field: OrderPositionsFieldEnum::CONFIGURATION, value: $orderPosition->product_details2);
            $orderPositionsFields[] = $fieldCreator->customText(field: OrderPositionsFieldEnum::PRICE, value: $orderPosition->priceFormatted);
            $orderPositionsFields[] = $fieldCreator->customText(field: '', value: '');
        }

        $orderPositionsFields[] = $fieldCreator->customText(field: 'net', value: $orderPositions->totalCostFormatted());
        $orderPositionsFields[] = $fieldCreator->customText(field: 'gross', value: $orderPositions->grossFormatted());
        $orderPositionsFields[] = $fieldCreator->customUrl(field: 'upload_center_url', value: route('order.upload-center', ['language' => $language, 'sessionId' => $sessionId]));

        return [
            Fieldset::make(fields: [
                $fieldCreator->enum(field: OrderFieldEnum::CUSTOMER_TYPE, enum: CustomerTypeEnum::class),
                $fieldCreator->text(field: OrderFieldEnum::FIRSTNAME),
                $fieldCreator->text(field: OrderFieldEnum::LASTNAME),
                $fieldCreator->email(field: OrderFieldEnum::EMAIL),
                $fieldCreator->phone(field: OrderFieldEnum::PHONE),
                $fieldCreator->text(field: OrderFieldEnum::STREET),
                $fieldCreator->text(field: OrderFieldEnum::CITY),
                $fieldCreator->text(field: OrderFieldEnum::POSTAL_CODE),
                $fieldCreator->checkbox(field: OrderFieldEnum::IS_RECIPIENT_DIFFERENT),
                $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_FIRSTNAME),
                $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_LASTNAME),
                $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_STREET),
                $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_CITY),
                $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_POSTAL_CODE),
                $fieldCreator->enum(field: OrderFieldEnum::PAYMENT, enum: PaymentEnum::class),
                $fieldCreator->enum(field: OrderFieldEnum::STATUS, enum: StatusEnum::class),
            ]),

            Fieldset::make(fields: $orderPositionsFields),
        ];
    }
}

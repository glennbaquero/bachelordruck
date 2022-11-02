<?php

namespace Domain\Orders\FormGrids;

use App\Livewire\View\Fieldset;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\FieldEnums\OrderFieldEnum;
use Support\Creators\FormFieldCreator;

class OrdersFormGrid
{
    private string $modelName = 'order';

    public function __invoke(): array
    {
        $fieldCreator = new FormFieldCreator($this->modelName);

        return [
            Fieldset::make(
                fields: [
                    $fieldCreator->select(field: OrderFieldEnum::CUSTOMER_TYPE, options: CustomerTypeEnum::options(), readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::FIRSTNAME, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::LASTNAME, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::EMAIL, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::PHONE, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::STREET, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::CITY, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::POSTAL_CODE, readonly: true),
                    $fieldCreator->checkbox(field: OrderFieldEnum::IS_RECIPIENT_DIFFERENT),
                    $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_FIRSTNAME, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_LASTNAME, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_STREET, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_CITY, readonly: true),
                    $fieldCreator->text(field: OrderFieldEnum::RECIPIENT_POSTAL_CODE, readonly: true),
                    $fieldCreator->select(field: OrderFieldEnum::PAYMENT, options: PaymentEnum::options(), readonly: true),
                    $fieldCreator->select(field: OrderFieldEnum::STATUS, options: StatusEnum::options()),

                ]
            ),
        ];
    }
}

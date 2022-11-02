<?php

namespace Domain\Orders\FieldEnums;

use App\Contracts\FieldEnumContract;
use App\Traits\WithFieldLabels;

enum OrderFieldEnum: string implements FieldEnumContract
{
    use WithFieldLabels;

    case ID = 'id';
    case SESSION_ID = 'session_id';
    case CUSTOMER_TYPE = 'customer_type';
    case TITLE = 'title';
    case FIRSTNAME = 'firstname';
    case LASTNAME = 'lastname';
    case EMAIL = 'email';
    case PHONE = 'phone';
    case STREET = 'street';
    case POSTAL_CODE = 'postal_code';
    case CITY = 'city';
    case IS_RECIPIENT_DIFFERENT = 'is_recipient_different';
    case RECIPIENT_TITLE = 'recipient_title';
    case RECIPIENT_FIRSTNAME = 'recipient_firstname';
    case RECIPIENT_LASTNAME = 'recipient_lastname';
    case RECIPIENT_STREET = 'recipient_street';
    case RECIPIENT_POSTAL_CODE = 'recipient_postal_code';
    case RECIPIENT_CITY = 'recipient_city';
    case TOTAL_AMOUNT = 'total_amount';
    case PAYMENT = 'payment';
    case STATUS = 'status';

    public function payload(): array
    {
        return [];
    }
}

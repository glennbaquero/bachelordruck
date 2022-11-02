<?php

namespace Domain\Pages\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ContactUsData extends DataTransferObject
{
    public string $gender;

    public string $first_name;

    public string $last_name;

    public ?string $company;

    public ?string $street;

    public ?string $postcode;

    public ?string $location;

    public string $email;

    public ?string $message;

    public ?string $country;

    public static function fromRequest(Request $request): ContactUsData
    {
        return new self(
            gender: $request->get('gender'),
            first_name: $request->get('first-name'),
            last_name: $request->get('last-name'),
            company: $request->get('company', null),
            street: $request->get('street', null),
            postcode: $request->get('postcode', null),
            location: $request->get('location', null),
            email: $request->get('email'),
            message: $request->get('message', null),
            country: $request->get('country', null),
        );
    }
}

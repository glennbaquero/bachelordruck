<?php

namespace App\Pages\Services;

use App\Pages\Mails\ContactUs;
use Domain\Pages\DataTransferObjects\ContactUsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsMailService
{
    public function handle(Request $request)
    {
        $contactData = ContactUsData::fromRequest($request);
        Mail::to('twocngdagz@gmail.com')->send(new ContactUs($contactData));
    }
}

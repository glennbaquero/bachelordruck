<?php

namespace App\Pages\Mails;

use Domain\Pages\DataTransferObjects\ContactUsData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ContactUsData $contactUsData)
    {
    }

    public function build()
    {
        return $this->view('emails.contact_us')
            ->subject('Contact Us Data');
    }
}

<?php

namespace Domain\Orders\Mailables;

use Domain\Orders\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $title = '';

    public string $url = '';

    public function __construct(public Order $order)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->order->loadMissing('orderPositions.product');

        $this->title = __('Order Confirmation');

        return $this
            ->subject($this->title)
            ->markdown('mails.order-confirmation');
    }
}

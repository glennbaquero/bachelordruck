<?php

namespace App\Livewire\Bachelordruck;

use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\Actions\OrderConfirmAction;
use Domain\Orders\Actions\OrderPaymentCreateAction;
use Domain\Orders\Actions\OrderUpdateAction;
use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\DataTransferObjects\OrderPaymentData;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Jobs\SendOrderConfirmationMail;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderPayment as PaymentModel;
use Domain\Orders\Presets\OrderPaymentPreset;
use Domain\Orders\Services\BasketService;
use Livewire\Component;

class OrderPayment extends Component
{
    use DefaultLayoutDataTrait;

    public $basketPositions;

    public $order;

    public $paymentData;

    public string $language;

    public $paymentMethod;

    protected $listeners = ['paymentSuccess' => 'paymentSuccess'];

    public function mount(string $language)
    {
        $this->basketPositions = BasketService::session(session()->getId())->get();
        $this->order = Order::where('session_id', session()->getId())->first();

        if (empty($this->order)) {
            return redirect()->route('order.contact-details', ['de']);
        }

        $this->language = $language;
    }

    public function render()
    {
        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.orders.order-payment')
            ->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language))
            ->slot('livewireContent');
    }

    public function paymentSuccess($response = [])
    {
        $this->order->payment = $this->paymentMethod;
        $this->order->status = StatusEnum::READY_FOR_PRODUCTION;

        $orderData = OrderData::fromModel($this->order);
        app(OrderUpdateAction::class)($this->order, $orderData);

        app(OrderConfirmAction::class)($this->order);

        if ($this->paymentMethod !== PaymentEnum::PAYMENT_IN_ADVANCE->value) {
            $this->storePaypalResponse($response);
        }

        $this->order->load('orderPositions.product');

        SendOrderConfirmationMail::dispatch($this->order);

        $redirect = route('order.confirmation-and-data-upload', [$language = 'de', 'sessionId' => $this->order->session_id]);

        return redirect()->to(route('renew_session', [$language = 'de', 'redirect' => $redirect]));
    }

    private function storePaypalResponse($response)
    {
        $orderPayment = PaymentModel::where('order_id', $this->order->id)->first();

        if (! $orderPayment) {
            $orderPayment = app(OrderPaymentPreset::class)();
        }

        $orderPayment->order_id = $this->order->id;
        $orderPayment->reference = $response['id'];
        $orderPayment->status = $response['status'];
        $orderPayment->intent = $response['intent'];
        $orderPayment->response = $response;

        $orderPaymentData = OrderPaymentData::fromModel($orderPayment);
        app(OrderPaymentCreateAction::class)($orderPaymentData);
    }
}

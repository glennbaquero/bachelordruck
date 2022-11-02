<?php

namespace App\Livewire\Bachelordruck;

use App\Enums\SalutationEnum;
use App\Livewire\Base\Form;
use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\Actions\OrderCreateAction;
use Domain\Orders\Actions\OrderUpdateAction;
use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\Enums\CustomerTypeEnum;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\FieldEnums\OrderFieldEnum;
use Domain\Orders\Models\Order;
use Domain\Orders\Presets\OrderPreset;
use Domain\Orders\Rules\OrderRules;
use Domain\Orders\Services\BasketService;
use Illuminate\View\View;
use Livewire\Redirector;
use function view;

class ContactDetails extends Form
{
    use DefaultLayoutDataTrait;

    public string $name = 'contactDetails';

    public Order $order;

    public array $titleOptions = [];

    public string $language;

    public function mount(string $language): void
    {
        $this->language = $language;

        $this->redirectIfBasketIsEmpty();

        $this->setTitleOptions();

        $this->setOrder();
    }

    private function setTitleOptions()
    {
        $this->titleOptions = SalutationEnum::options();
    }

    protected function redirectIfBasketIsEmpty(): bool|Redirector
    {
        if (BasketService::session(session()->getId())->count() === 0) {
            return redirect()->route('order.basket-items', ['language' => $this->language]);
        }

        return false;
    }

    protected function setOrder()
    {
        $order = Order::where('session_id', session()->getId())->first();

        if ($order) {
            $this->order = $order;
        } else {
            $this->order = app(OrderPreset::class)();
        }
    }

    public function updatingOrderCustomerType(&$value)
    {
        $value = CustomerTypeEnum::from($value);
    }

    public function updatingOrderStatus(&$value)
    {
        $value = StatusEnum::from($value);
    }

    public function updatingOrderPayment(&$value)
    {
        $value = PaymentEnum::from($value);
    }

    public function render(): View
    {
        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.orders.contact-details', [
        ])
            ->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language))
            ->slot('livewireContent');
    }

    public function create(): Redirector
    {
        $this->validate();

        $orderData = OrderData::fromModel($this->order);

        if ($this->order->id) {
            app(OrderUpdateAction::class)($this->order, $orderData);
        } else {
            $order = app(OrderCreateAction::class)($orderData);
            $this->order->id = $order->id;
        }

        return redirect()->to(route('order.payment', ['language' => $this->language]));
    }

    public function grids(): array
    {
        return [];
    }

    public function rules(): array
    {
        return OrderRules::getRules();
    }

    protected function validationAttributes(): array
    {
        return OrderFieldEnum::labels();
    }
}

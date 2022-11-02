<?php

namespace App\Livewire\Bachelordruck;

use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\Actions\OrderConfirmAction;
use Domain\Orders\Models\Order;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use function view;

class ConfirmationAndDataUpload extends Component
{
    use DefaultLayoutDataTrait;
    use WithMedia;

    public string $name = 'confirmationAndFileUpload';

    public Order $order;

    public $mediaComponentNames = ['files'];

    public $files;

    public string $language;

    public string $sessionId;

    public function mount(string $language, string $sessionId): void
    {
        $this->language = $language;
        $this->sessionId = $sessionId;

        $this->redirectIfOrderNotExists();
    }

    protected function redirectIfOrderNotExists(): bool|Redirector
    {
        if (! Order::where('session_id', $this->sessionId)->first()) {
            return redirect()->to(route('order.contact-details', ['language' => $this->language]));
        }

        return false;
    }

    /**
     * @throws UnknownProperties
     */
    public function confirm(): Redirector
    {
        /** @var Order $order */
        $order = Order::where('session_id', session()->getId())->first();

        $order->addFromMediaLibraryRequest($this->files)
            ->toMediaCollection('files');

        app(OrderConfirmAction::class)($order);

        $this->clearMedia();

        // TODO: Adjust when payment page is done.
        $redirect = route('order.upload-center', [$language = 'de', 'sessionId' => $order->session_id]);

        return redirect()->to(route('renew_session', [$language = 'de', 'redirect' => $redirect]));
    }

    public function render(): View
    {
        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.orders.confirmation-and-data-upload', [
        ])
            ->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language))
            ->slot('livewireContent');
    }
}

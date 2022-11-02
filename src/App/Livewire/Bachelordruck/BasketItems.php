<?php

namespace App\Livewire\Bachelordruck;

use App\Traits\DefaultLayoutDataTrait;
use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Services\BasketService;
use Livewire\Component;

class BasketItems extends Component
{
    use DefaultLayoutDataTrait;

    public $basketPosition;

    protected $listeners = ['basketUpdated' => 'updateBasket'];

    public string $language;

    public function mount(string $language)
    {
        $this->language = $language;

        $this->updateBasket();
    }

    public function render()
    {
        config()->set('cms.featured', false);

        return view('livewire.bachelordruck.orders.basket-items', [
        ])
            ->layout('layouts.bachelordruck.page', $this->defaultLayoutData($this->language))
            ->slot('livewireContent');
    }

    public function updateBasket()
    {
        $this->basketPosition = BasketService::session(session()->getId())->get();
    }

    public function removeItem(BasketPosition $basketPosition)
    {
        BasketService::session(session()->getId())->remove($basketPosition);
        $this->updateBasket();
        $this->emit('basketUpdated');
        $this->emit('updateBasketCounter');
    }
}

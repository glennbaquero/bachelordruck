<?php

namespace App\Livewire\Bachelordruck;

use Domain\Orders\Services\BasketService;
use Livewire\Component;

class BasketCounter extends Component
{
    public $basketPositionCount;

    protected $listeners = ['updateBasketCounter' => 'updateCartCounterHandler'];

    public function mount()
    {
        $this->updateCartCounterHandler();
    }

    public function render()
    {
        return view('livewire.bachelordruck.basket-counter');
    }

    public function updateCartCounterHandler()
    {
        $this->basketPositionCount = count(BasketService::session(session()->getId())->get());
    }
}

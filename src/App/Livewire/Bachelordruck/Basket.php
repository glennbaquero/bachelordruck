<?php

namespace App\Livewire\Bachelordruck;

use Domain\Orders\Models\BasketPosition;
use Domain\Orders\Services\BasketService;
use Livewire\Component;
use function view;

class Basket extends Component
{
    public $basketPositions;

    protected $listeners = ['basketUpdated' => 'updateBasket'];

    public function mount()
    {
        $this->updateBasket();
    }

    public function render()
    {
        return view('livewire.bachelordruck.basket');
    }

    public function updateBasket()
    {
        $this->basketPositions = BasketService::session(session()->getId())->get();
    }

    public function removeItem(BasketPosition $basketPosition)
    {
        BasketService::session(session()->getId())->remove($basketPosition);
        $this->emit('basketUpdated');
        $this->emit('updateBasketCounter');
    }
}

<?php

namespace App\Livewire\Domain\Orders\Edit;

use App\Livewire\Base\Form;
use App\Livewire\Traits\WithFormDeleteAction;
use Domain\Orders\Actions\OrderStatusUpdateAction;
use Domain\Orders\DataTransferObjects\OrderData;
use Domain\Orders\FieldEnums\OrderFieldEnum;
use Domain\Orders\FormGrids\OrdersFormGrid;
use Domain\Orders\Models\Order;
use Domain\Orders\Rules\OrderStatusRules;
use Livewire\Redirector;

class OrdersEdit extends Form
{
    use WithFormDeleteAction;

    public string $name = 'order';

    public Order $order;

    public function mount(Order $model)
    {
        $this->hideDeleteButton = true;
        $this->order = $model;
    }

    public function grids(): array
    {
        return app(OrdersFormGrid::class)();
    }

    public function rules(): array
    {
        return OrderStatusRules::getRules($this->order);
    }

    protected function validationAttributes(): array
    {
        return OrderFieldEnum::labels();
    }

    public function update(OrderStatusUpdateAction $orderStatusUpdateAction): Redirector
    {
        $this->validate();
        $newsData = OrderData::fromModel($this->order);
        $this->order = $orderStatusUpdateAction($this->order, $newsData);

        session()->flash('message', __('notification.update_message', ['model' => __('model.'.$this->name)]));

        return redirect()->to(route('order.list'));
    }
}

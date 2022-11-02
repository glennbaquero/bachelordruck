<?php

namespace App\Livewire\Domain\Orders\Show;

use App\Livewire\Base\Show;
use App\Livewire\Traits\WithFormDeleteAction;
use Domain\Orders\Models\Order;
use Domain\Orders\ShowGrids\OrderShowGrid;
use Livewire\Redirector;

class OrderShow extends Show
{
    use WithFormDeleteAction;

    public string $name = 'order';

    public Order   $model;

    public function mount(Order $model): void
    {
        $this->model = $model;
        $this->hideDeleteButton = true;
        $this->model->load(['orderPositions']);
    }

    public function grids(): array
    {
        return app(OrderShowGrid::class)(orderPositions: $this->model->orderPositions, language: 'de', sessionId: $this->model->session_id);
    }

    public function edit(): Redirector
    {
        return redirect()->to(route('order.edit', ['model' => $this->model->id]));
    }
}

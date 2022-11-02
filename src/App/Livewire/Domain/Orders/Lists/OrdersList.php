<?php

namespace App\Livewire\Domain\Orders\Lists;

use App\Livewire\Base\DataTable;
use App\Livewire\View\Column;
use Domain\Orders\Enums\PaymentEnum;
use Domain\Orders\Enums\StatusEnum;
use Domain\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrdersList extends DataTable
{
    public function mount(): void
    {
        $this->searchPlaceholder = __('placeholder.search', ['model' => __('model.order')]);
    }

    public function columns(): array
    {
        return [
            Column::action(
                action: 'show'
            )->setCallback(
                fn ($id) => redirect(sprintf('/orders/%s', $id))
            ),
            Column::text(
                field: 'full_name',
                token: 'order',
            ),
            Column::email(
                field: 'email',
                token: 'order',
            )->sortable(),
            Column::decimal(
                field: 'total_amount',
                token: 'order',
            )->sortable(),
            Column::enum(
                field: 'payment',
                token: 'order',
                enum: PaymentEnum::class,
            )->sortable(),
            Column::enum(
                field: 'status',
                token: 'order',
                enum: StatusEnum::class,
            )->sortable(),
            Column::action(
                action: 'edit'
            )->setCallback(
                fn ($id) => redirect(sprintf('/orders/%s/edit', $id))
            ),
        ];
    }

    public function query(): Builder
    {
        return Order::query()->with('orderPositions', 'orderPayment');
    }
}

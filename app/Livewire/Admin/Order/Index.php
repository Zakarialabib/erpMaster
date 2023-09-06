<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;

    public $status;

    public array $listsForFields = [];

    public function mount()
    {
        $this->orderable = (new Order())->orderable;
    }

    public function render(): View|Factory
    {
        $query = Order::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $orders = $query->paginate($this->perPage);

        return view('livewire.admin.order.index', compact('orders'));
    }
}

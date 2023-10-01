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

    public $model = Order::class;

    public $order;

    public $showFilters = false;

    public $startDate;

    public $endDate;

    public function mount(): void
    {
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfDay()->format('Y-m-d');
    }

    public function filterByType($type): void
    {
        switch ($type) {
            case 'day':
                $this->startDate = now()->startOfDay()->format('Y-m-d');
                $this->endDate = now()->endOfDay()->format('Y-m-d');

                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');

                break;
            case 'year':
                $this->startDate = now()->startOfYear()->format('Y-m-d');
                $this->endDate = now()->endOfYear()->format('Y-m-d');

                break;
        }
    }

    public function render(): View|Factory
    {
        $query = Order::whereBetween('date', [$this->startDate, $this->endDate])
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $orders = $query->paginate($this->perPage);

        return view('livewire.admin.order.index', ['orders' => $orders]);
    }
}

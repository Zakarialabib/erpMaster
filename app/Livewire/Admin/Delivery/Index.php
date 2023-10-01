<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Delivery;

use App\Livewire\Utils\Datatable;
use App\Models\Delivery;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $delivery;

    public $showFilters = false;

    public $startDate;

    public $endDate;

    public $model = Delivery::class;

    public function mount(): void
    {
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfYear()->format('Y-m-d');
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

    public function render()
    {
        abort_if(Gate::denies('delivery access'), 403);

        $query = Delivery::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $deliveries = $query->paginate($this->perPage);

        return view('livewire.admin.delivery.index', ['deliveries' => $deliveries]);
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('delivery_delete'), 403);

        Delivery::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Delivery $delivery): void
    {
        abort_if(Gate::denies('delivery_delete'), 403);

        $delivery->delete();
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Shipping;

use App\Models\Shipping;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;
use Illuminate\Support\Facades\Gate;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $listeners = [
        'delete',
    ];

    public $shipping;

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function mount()
    {
        $this->orderable = (new Shipping())->orderable;
    }

    public function render(): View|Factory
    {
        abort_if(Gate::denies('shipping access'), 403);

        $query = Shipping::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $shippings = $query->paginate($this->perPage);

        return view('livewire.admin.shipping.index', ['shippings' => $shippings]);
    }

    public function deleteModal($shipping)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->shipping = $shipping;
    }

    public function delete()
    {
        abort_if(Gate::denies('shipping delete'), 403);

        Shipping::findOrFail($this->shipping)->delete();

        $this->alert('success', __('Shipping deleted successfully.'));
    }
}

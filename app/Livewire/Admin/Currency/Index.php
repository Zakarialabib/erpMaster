<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Livewire\Utils\Datatable;
use App\Models\Currency;
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
    public $currency;

    /** @var array<string> */
    public $listeners = [
        'showModal',
    ];

    public $showModal = false;

    public $editModal = false;

    public function mount(): void
    {
        $this->orderable = (new Currency())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('currency access'), 403);

        $query = Currency::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $currencies = $query->paginate($this->perPage);

        return view('livewire.admin.currency.index', compact('currencies'));
    }

    public function showModal(Currency $currency): void
    {
        abort_if(Gate::denies('currency_show'), 403);

        $this->currency = Currency::find($currency->id);

        $this->showModal = true;
    }

    public function delete(Currency $currency): void
    {
        abort_if(Gate::denies('currency_delete'), 403);

        $currency->delete();

        $this->alert('success', __('Currency deleted successfully!'));
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Quotations;

use App\Livewire\Utils\Datatable;
use App\Models\Customer;
use App\Models\Quotation;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use Datatable;
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;

    public $quotation;

    /** @var array<string> */
    public $listeners = [
        'showModal', 'delete',
    ];

    /** @var bool */
    public $showModal = false;

    public $listsForFields = [];

    public function mount(): void
    {
        $this->orderable = (new Quotation())->orderable;
        $this->initListsForFields();
    }

    public function render()
    {
        abort_if(Gate::denies('quotation_access'), 403);

        $query = Quotation::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $quotations = $query->paginate($this->perPage);

        return view('livewire.admin.quotations.index', compact('quotations'));
    }

    public function showModal(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_access'), 403);

        $this->quotation = Customer::findOrFail($quotation->customer_id);

        $this->showModal = true;
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('quotation_delete'), 403);

        Quotation::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Quotation $product)
    {
        abort_if(Gate::denies('quotation_delete'), 403);

        $product->delete();

        $this->alert('success', __('Quotation deleted successfully.'));
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['customers'] = Customer::pluck('name', 'id')->toArray();
    }
}

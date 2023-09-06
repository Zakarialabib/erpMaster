<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Exports\CustomerExport;
use App\Livewire\Utils\Datatable;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithFileUploads;

    public $customer;

    public $file;

    public $listeners = [
        'showModal',
        'exportAll', 'downloadAll',
        'delete',
    ];

    public $showModal = false;

    public $import;

    public function mount(): void
    {
        $this->orderable = (new Customer())->orderable;
    }

    public function render(): View|Factory
    {
        abort_if(Gate::denies('customer access'), 403);

        $query = Customer::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $customers = $query->paginate($this->perPage);

        return view('livewire.admin.customers.index', compact('customers'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('customer_delete'), 403);

        Customer::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), 403);

        $customer->delete();

        $this->alert('warning', __('Customer deleted successfully'));
    }

    public function showModal($id): void
    {
        abort_if(Gate::denies('customer access'), 403);

        $this->customer = Customer::find($id);

        $this->showModal = true;
    }

    public function downloadSelected(): BinaryFileResponse|Response
    {
        abort_if(Gate::denies('customer access'), 403);

        $customers = Customer::whereIn('id', $this->selected)->get();

        return (new CustomerExport($customers))->download('customers.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function downloadAll(Customer $customers): BinaryFileResponse|Response
    {
        abort_if(Gate::denies('customer access'), 403);

        return (new CustomerExport($customers))->download('customers.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function exportSelected(): BinaryFileResponse|Response
    {
        abort_if(Gate::denies('customer access'), 403);

        return $this->callExport()->forModels($this->selected)->download('customers.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function exportAll(): BinaryFileResponse|Response
    {
        abort_if(Gate::denies('customer access'), 403);

        return $this->callExport()->download('customers.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function import(): void
    {
        abort_if(Gate::denies('customer access'), 403);

        $this->import = true;
    }

    public function importExcel()
    {
        abort_if(Gate::denies('customer access'), 403);

        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $this->file('file');

        Excel::import(new CustomerImport(), $file);

        $this->import = false;

        $this->alert('success', __('Customer imported successfully.'));
    }

    private function callExport(): CustomerExport
    {
        return new CustomerExport();
    }
}

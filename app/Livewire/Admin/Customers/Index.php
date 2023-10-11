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
        'delete',
    ];

    public $importModal = false;

    public $model = Customer::class;

    public function render(): View|Factory
    {
        abort_if(Gate::denies('customer access'), 403);

        $query = Customer::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $customers = $query->paginate($this->perPage);

        return view('livewire.admin.customers.index', ['customers' => $customers]);
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('customer delete'), 403);

        Customer::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Customer $customer): void
    {
        abort_if(Gate::denies('customer delete'), 403);

        $customer->delete();

        $this->alert('warning', __('Customer deleted successfully'));
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

    public function importExcel(): void
    {
        abort_if(Gate::denies('customer access'), 403);

        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new CustomerImport(), $this->file);

        $this->importModal = false;

        $this->alert('success', __('Customer imported successfully.'));
    }

    private function callExport(): CustomerExport
    {
        return new CustomerExport();
    }

    public function downloadSample()
    {
        return Storage::disk('exports')->download('customers_import_sample.xls');
    }

}

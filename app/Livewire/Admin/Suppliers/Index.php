<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Suppliers;

use App\Exports\SupplierExport;
use App\Livewire\Utils\Datatable;
use App\Imports\SupplierImport;
use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $supplier;
    
    public $file;
    
    public $model = Supplier::class;

    /** @var array<string> */
    public $listeners = [
        'importModal',
        'downloadAll', 'exportAll', 'delete',
    ];

    /** @var bool */
    public $importModal = false;

    public function render()
    {
        abort_if(Gate::denies('supplier access'), 403);

        $query = Supplier::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $suppliers = $query->paginate($this->perPage);

        return view('livewire.admin.suppliers.index', ['suppliers' => $suppliers]);
    }

    public function delete(Supplier $supplier): void
    {
        abort_if(Gate::denies('supplier_delete'), 403);

        $supplier->delete();

        $this->alert('warning', __('Supplier Deleted Successfully'));
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('supplier_delete'), 403);

        Supplier::whereIn('id', $this->selected)->delete();

        $this->selected = [];
    }

    public function importModal(): void
    {
        abort_if(Gate::denies('supplier_import'), 403);

        $this->importModal = true;
    }

    public function downloadSample()
    {
        return Storage::disk('exports')->download('suppliers_import_sample.xls');
    }

    public function import(): void
    {
        abort_if(Gate::denies('supplier import'), 403);

        $this->validate([
            'import_file' => [
                'required',
                'file',
            ],
        ]);

        Supplier::import(new SupplierImport(), $this->file('import_file'));

        $this->alert('success', __('Supplier Imported Successfully'));

        $this->importModal = false;
    }

    public function downloadSelected()
    {
        abort_if(Gate::denies('supplier access'), 403);

        $suppliers = Supplier::whereIn('id', $this->selected)->get();

        return (new SupplierExport($suppliers))->download('suppliers.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function downloadAll(Supplier $suppliers)
    {
        abort_if(Gate::denies('supplier access'), 403);

        return (new SupplierExport($suppliers))->download('suppliers.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function exportSelected(): BinaryFileResponse
    {
        abort_if(Gate::denies('supplier access'), 403);

        // $suppliers = Supplier::whereIn('id', $this->selected)->get();

        return $this->callExport()->forModels($this->selected)->download('suppliers.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function exportAll(): BinaryFileResponse
    {
        abort_if(Gate::denies('supplier access'), 403);

        return $this->callExport()->download('suppliers.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    private function callExport(): SupplierExport
    {
        return new SupplierExport();
    }
}

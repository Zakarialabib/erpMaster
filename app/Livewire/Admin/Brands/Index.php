<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Brands;

use App\Livewire\Utils\Datatable;
use App\Imports\BrandsImport;
use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use Datatable;

    /** @var mixed */
    public $brand;

    public $brandIds;

    /** @var array<string> */
    public $listeners = [
        'showModal', 'importModal',
        'delete',
    ];

    public $image;

    public $file;

    /** @var bool */
    public $showModal = false;

    /** @var bool */
    public $deleteModal = false;

    /** @var bool */
    public $importModal = false;

    public $model = Brand::class;

    public function render()
    {
        abort_if(Gate::denies('brand access'), 403);

        $query = Brand::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $brands = $query->paginate($this->perPage);

        return view('livewire.admin.brands.index', ['brands' => $brands]);
    }

    public function showModal(Brand $brand): void
    {
        abort_if(Gate::denies('brand_show'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->brand = Brand::find($brand->id);

        $this->showModal = true;
    }

    public function confirmed(): void
    {
        $this->dispatch('delete');
    }

    public function deleteModal($brand): void
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->brand = $brand;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('brand_delete'), 403);

        Brand::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(): void
    {
        abort_if(Gate::denies('brand_delete'), 403);

        Brand::findOrFail($this->brand)->delete();

        $this->alert('success', __('Brand deleted successfully.'));
    }

    public function importModal(): void
    {
        abort_if(Gate::denies('brand_import'), 403);

        $this->importModal = true;
    }

    public function downloadSample()
    {
        return Storage::disk('exports')->download('brands_import_sample.xls');
    }

    public function import(): void
    {
        abort_if(Gate::denies('brand_import'), 403);

        $this->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new BrandsImport(), $this->file);

        $this->alert('success', __('Brand imported successfully.'));
    }
}

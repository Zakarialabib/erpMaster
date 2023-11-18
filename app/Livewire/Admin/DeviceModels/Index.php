<?php

declare(strict_types=1);

namespace App\Livewire\Admin\DeviceModels;

use App\Livewire\WithSorting;
use App\Imports\DeviceModelImport;
use App\Models\DeviceModel;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $device_model;

    public $listeners = [
        'refreshIndex' => '$refresh',
        'showModal', 'importModal',
        'delete',
    ];

    public $deleteModal = false;

    public $showModal = false;

    public $importModal = false;

    public int $perPage;

    public array $orderable;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],
        'sortBy' => [
            'except' => 'id',
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public function getImagePreviewProperty()
    {
        return $this->device_model?->image;
    }

    public function getFeaturedImagePreviewProperty()
    {
        return $this->device_model?->featured_image;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function resetSelected(): void
    {
        $this->selected = [];
    }

    public function confirmed(): void
    {
        $this->emit('delete');
    }

    public function mount(): void
    {
        $this->perPage = 100;
        $this->paginationOptions = [25, 50, 100];
        $this->orderable = (new DeviceModel())->orderable;
    }

    public function render(): View|Factory
    {
        // abort_if(Gate::denies('device_model_access'), 403);

        $query = DeviceModel::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $device_models = $query->paginate($this->perPage);

        return view('livewire.admin.device-models.index', compact('device_models'))->extends('layouts.dashboard');
    }

    public function showModal(DeviceModel $device_model): void
    {
        // abort_if(Gate::denies('device_model_show'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->device_model = $device_model;

        $this->showModal = true;
    }

    public function deleteModal($device_model): void
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->device_model = $device_model;
    }

    public function deleteSelected(): void
    {
        // abort_if(Gate::denies('device_model_delete'), 403);

        DeviceModel::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(): void
    {
        // abort_if(Gate::denies('device_model_delete'), 403);

        DeviceModel::findOrFail($this->device_model)->delete();

        $this->alert('success', __('DeviceModel deleted successfully.'));
    }

    public function importModal(): void
    {
        // abort_if(Gate::denies('device_model_create'), 403);

        $this->importModal = true;
    }

    public function import(): void
    {
        // abort_if(Gate::denies('device_model_create'), 403);

        $this->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new DeviceModelImport(), $this->file);

        $this->alert('success', __('DeviceModel imported successfully.'));
    }
}

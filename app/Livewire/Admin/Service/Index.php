<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Service;

use App\Models\Service;
use App\Livewire\Utils\Datatable;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $service;

    public $deleteModal = false;

    public $showModal = false;

    public $listeners = [
        'showModal', 'delete',
    ];

    public function mount()
    {
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new Service())->orderable;
    }

    public function render()
    {
        $query = Service::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $services = $query->paginate($this->perPage);

        return view('livewire.admin.service.index', compact('services'));
    }

    public function showModal(Service $service)
    {
        abort_if(Gate::denies('service_show'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->service = $service;

        $this->showModal = true;
    }

    public function delete()
    {
        abort_if(Gate::denies('service_delete'), 403);

        Service::findOrFail($this->service)->delete();

        $this->alert('success', __('Service deleted successfully.'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('service_delete'), 403);

        Service::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Service deleted successfully.'));
    }

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function deleteModal($service)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->service = $service;
    }

    // Service  Clone
    // public function clone(Service $service)
    // {
    //     $service_details = Service::find($service->id);
    //     // dd($service_details);
    //     Service::create([
    //         'title'   => $service_details->title,
    //         'slug'    => $service_details->slug,
    //         'image'   => $service_details->image,
    //         'content' => $service_details->content,
    //         'status'  => 0,
    //     ]);
    //     $this->alert('success', __('Service Cloned successfully!'));
    // }
}

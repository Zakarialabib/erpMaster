<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Package;

use App\Models\Package;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $deleteModal = false;
    public $package;

    public function mount()
    {
        $this->orderable = (new Package())->orderable;
    }

    public function render()
    {
        $query = Package::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $packages = $query->paginate($this->perPage);

        return view('livewire.admin.package.index', compact('packages'));
    }

    #[On('delete')]
    public function delete()
    {
        // abort_if(Gate::denies('package_delete'), 403);

        Package::findOrFail($this->package)->delete();

        $this->alert('success', __('Package deleted successfully.'));
    }

    public function deleteSelected()
    {
        // abort_if(Gate::denies('package_delete'), 403);

        Package::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Package deleted successfully.'));
    }

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function deleteModal($package)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->package = $package;
    }
}

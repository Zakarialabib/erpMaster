<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use WithPagination;
    use Datatable;
    use LivewireAlert;

    public $listeners = [
        'delete',
    ];

    public $subcategory;

    public $deleteModal = false;

    public $image;

    public $model = Subcategory::class;

    public function confirmed(): void
    {
        $this->dispatch('delete');
    }

    public function render(): View|Factory
    {
        $query = Subcategory::with('category')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $subcategories = $query->paginate($this->perPage);

        return view('livewire.admin.subcategory.index', ['subcategories' => $subcategories]);
    }

    public function deleteModal($subcategory): void
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->subcategory = $subcategory;
    }

    public function delete(): void
    {
        abort_if(Gate::denies('subcategory_delete'), 403);

        Subcategory::findOrFail($this->subcategory)->delete();

        $this->alert('success', __('Subcategory deleted successfully.'));
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('subcategor delete'), 403);

        Subcategory::whereIn('id', $this->selected)->delete();

        $this->alert('success', __('Subcategory deleted successfully.'));

        $this->resetSelected();
    }
}

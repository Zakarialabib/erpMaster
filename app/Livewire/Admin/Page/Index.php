<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Livewire\Utils\Datatable;

class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $listeners = [
        'refreshIndex' => '$refresh',
        'delete',
    ];

    public $deleteModal = false;

    public array $listsForFields = [];

   

    public function mount()
    {
        $this->orderable = (new Page())->orderable;
    }

    public function render(): View|Factory
    {
        $query = Page::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $pages = $query->paginate($this->perPage);

        return view('livewire.admin.page.index', compact('pages'));
    }

    public function delete()
    {
        // abort_if(Gate::denies('page_delete'), 403);

        Page::findOrFail($this->page)->delete();

        $this->alert('success', __('Page deleted successfully.'));
    }

    public function deleteSelected()
    {
        // abort_if(Gate::denies('page_delete'), 403);

        Page::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Page deleted successfully.'));
    }

    public function confirmed()
    {
        $this->emit('delete');
    }

    public function deleteModal($page)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->page = $page;
    }
}

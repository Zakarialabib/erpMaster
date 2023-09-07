<?php

declare(strict_types=1);

namespace App\Livewire\Admin\BlogCategory;

use App\Livewire\Utils\Datatable;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $listeners = [
        'delete',
    ];

    public $blogcategory;

    public $deleteModal = false;

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function mount()
    {
        $this->orderable = (new BlogCategory())->orderable;
    }

    public function deleteModal($blogcategory)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->blogcategory = $blogcategory;
    }

    public function delete()
    {
        abort_if(Gate::denies('blogcategory_delete'), 403);

        BlogCategory::findOrFail($this->blogcategory)->delete();

        $this->alert('success', __('BlogCategory deleted successfully.'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('blogcategory_delete'), 403);

        BlogCategory::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function render()
    {
        $query = BlogCategory::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $blogcategories = $query->paginate($this->perPage);

        return view('livewire.admin.blog-category.index', ['blogcategories' => $blogcategories]);
    }
}

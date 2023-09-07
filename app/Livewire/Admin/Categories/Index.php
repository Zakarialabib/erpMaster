<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Livewire\Utils\Datatable;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithFileUploads;

    /** @var mixed */
    public $category;

    public $file;

    /** @var array<string> */
    public $listeners = [
        'showModal',
        'delete',
    ];

    /** @var bool */
    public $showModal = false;

    /** @var bool */
    public $deleteModal = false;

    public function mount(): void
    {
        $this->orderable = (new Category())->orderable;
    }

    public function render(): mixed
    {
        abort_if(Gate::denies('category access'), 403);

        $query = Category::with('products')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $categories = $query->paginate($this->perPage);

        return view('livewire.admin.categories.index', ['categories' => $categories]);
    }

    public function showModal(Category $category): void
    {
        abort_if(Gate::denies('category access'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->category = Category::find($category->id);

        $this->showModal = true;
    }

    public function confirmed()
    {
        $this->dispatch('delete');
    }

    public function deleteModal($category)
    {
        $this->confirm(__('Are you sure you want to delete this?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'delete',
        ]);
        $this->category = $category;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('category_delete'), 403);

        Category::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(): void
    {
        abort_if(Gate::denies('category_delete'), 403);

        if ($this->category->products->count() > 0) {
            $this->alert('error', __('Category has products.'));
        } else {
            Category::findOrFail($this->category)->delete();
            $this->alert('success', __('Category deleted successfully.'));
        }
    }
}

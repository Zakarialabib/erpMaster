<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Livewire\Utils\Admin\HasDelete;
use App\Livewire\Utils\Datatable;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithFileUploads;
    use HasDelete;

    /** @var mixed */
    public $category;

    public $file;

    /** @var bool */
    public $showModal = false;

    public $model = Category::class;

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

    #[On('showModal')]
    public function showModal(Category $category): void
    {
        abort_if(Gate::denies('category access'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->category = Category::find($category->id);

        $this->showModal = true;
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\ExpenseCategories;

use App\Livewire\Utils\Datatable;
use App\Models\ExpenseCategory;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use Datatable;
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $expenseCategory;

    public $showModal = false;

    /** @var array<string> */
    public $listeners = [
        'showModal',
        'refreshIndex' => '$refresh',
        'delete',
    ];

    public function mount(): void
    {
        $this->selectPage = false;

        $this->orderable = (new ExpenseCategory())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('expense_categories_access'), 403);

        $query = ExpenseCategory::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $expenseCategories = $query->paginate($this->perPage);

        return view('livewire.admin.expense-categories.index', compact('expenseCategories'));
    }

    public function showModal($id): void
    {
        abort_if(Gate::denies('expense_categories_show'), 403);

        $this->expenseCategory = ExpenseCategory::where('id', $id)->get();

        $this->showModal = true;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('expense_categories_delete'), 403);

        ExpenseCategory::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(ExpenseCategory $expenseCategory): void
    {
        abort_if(Gate::denies('expense_categories_delete'), 403);

        $expenseCategory->delete();

        $this->alert('success', __('Expense Category Deleted Successfully.'));
    }
}

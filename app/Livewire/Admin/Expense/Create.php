<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Expense;

use App\Livewire\Utils\Admin\WithModels;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithModels;

    public $createModal = false;

    public Expense $expense;

    #[Rule('required|string|max:255')]
    public $reference;

    #[Rule('required|integer|exists:expense_categories,id')]
    public $category_id;

    #[Rule('required|date')]
    public $date;

    #[Rule('required|numeric')]
    public $amount;

    #[Rule('nullable|string|min:3')]
    public $description;

    #[Rule('nullable')]
    public $user_id;

    #[Rule('nullable')]
    public $warehouse_id;

    public function render()
    {
        abort_if(Gate::denies('expense create'), 403);

        return view('livewire.admin.expense.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->date = date('Y-m-d');

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->expense->save($this->all());

        $this->expense->user()->associate(auth()->user());

        $this->alert('success', __('Expense created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }

    public function getExpenseCategoriesProperty()
    {
        return ExpenseCategory::select('name', 'id')->get();
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Expense;

use App\Models\Warehouse;
use Livewire\Component;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $editModal = false;

    /** @var mixed */
    public $expense;

    #[Rule('required|string|max:255')]
    public $reference;

    #[Rule('required|integer|exists:expense_categories,id')]
    public $category_id;

    #[Rule('required|date')]
    public $date;

    #[Rule('required|numeric')]
    public $amount;

    #[Rule('nullable|string|max:255')]
    public $description;


    public $warehouse_id;

    #[Computed]
    public function expenseCategories()
    {
        return ExpenseCategory::select('name', 'id')->get();
    }

    #[Computed]
    public function warehouses()
    {
        if (auth()->check()) {
            $user = auth()->user();

            return Warehouse::whereIn('id', $user->warehouses->pluck('id'))->select('name', 'id')->get();
        }

        return Warehouse::select('name', 'id')->get();
    }

    public function render()
    {
        return view('livewire.admin.expense.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('expense edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->expense = Expense::find($id);

        $this->reference = $this->expense->reference;
        $this->category_id = $this->expense->category_id;
        $this->date = $this->expense->date;
        $this->amount = $this->expense->amount;
        $this->description = $this->expense->description;
        $this->warehouse_id = $this->expense->warehouse_id;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->expense->update([
            'reference'    => $this->reference,
            'category_id'  => $this->category_id,
            'date'         => $this->date,
            'amount'       => $this->amount,
            'description'  => $this->description,
            'warehouse_id' => $this->warehouse_id,
        ]);

        $this->alert('success', __('Expense updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Expense;

use App\Livewire\Utils\Admin\WithModels;
use App\Models\CashRegister;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Computed;
use App\Livewire\Admin\CashRegister\Create as CashRegisterCreate;

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

    #[Rule('nullable|min:3')]
    public $description;

    #[Rule('nullable')]
    public $user_id;

    #[Rule('nullable')]
    public $warehouse_id;

    #[Rule('nullable')]
    public $cash_register_id;

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

        $this->user_id = auth()->user()->id;

        if (settings('default_warehouse_id') !== null) {
            $this->warehouse_id = settings('default_warehouse_id');
        }

        if($this->user_id && $this->warehouse_id) {
            $cashRegister = CashRegister::where('user_id', $this->user_id)
                ->where('warehouse_id', $this->warehouse_id)
                ->where('status', true)
                ->first();

            if ($cashRegister) {
                $this->cash_register_id = $cashRegister->id;
            } else {
                $this->dispatch('createModal')->to(CashRegisterCreate::class);
                return;
            }
        }

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->expense = Expense::create($this->all());

        $this->expense->user()->associate(auth()->user());

        $this->alert('success', __('Expense created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);
        
        $this->createModal = false;
        
        $this->reset(['reference', 'category_id', 'date', 'amount', 'description', 'user_id', 'warehouse_id', 'cash_register_id']);
    }
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
}

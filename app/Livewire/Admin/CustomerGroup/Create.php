<?php

declare(strict_types=1);

namespace App\Livewire\Admin\CustomerGroup;

use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public CustomerGroup $customergroup;

    /** @var array */
    protected $rules = [
        'customergroup.name'       => 'required|min:3|max:255',
        'customergroup.percentage' => 'required',
    ];

    protected $messages = [
        'customergroup.name.required'       => 'The name field cannot be empty.',
        'customergroup.percentage.required' => 'The percentage field cannot be empty.',
    ];

    public function render()
    {
        // abort_if(Gate::denies('expense_category create'), 403);

        return view('livewire.admin.customer-group.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $validatedData = $this->validate();

        $this->customergroup->save($validatedData);

        $this->alert('success', __('Customer group created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }
}

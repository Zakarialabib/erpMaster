<?php

declare(strict_types=1);

namespace App\Livewire\Admin\CustomerGroup;

use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public CustomerGroup $customergroup;

    #[Rule('required', message: 'The name field cannot be empty.')]
    #[Rule('min:3', message: 'The name must be at least 3 characters.')]
    #[Rule('max:255', message: 'The name may not be greater than 255 characters.')]
    public $name;

    #[Rule('required', message: 'The percentage field cannot be empty.')]
    public $percentage;

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
        $this->validate();

        CustomerGroup::create([
            'name'       => $this->name,
            'percentage' => $this->percentage,
        ]);

        $this->alert('success', __('Customer group created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }
}

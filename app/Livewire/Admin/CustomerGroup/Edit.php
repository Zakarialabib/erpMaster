<?php

declare(strict_types=1);

namespace App\Livewire\Admin\CustomerGroup;

use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $editModal = false;

    /** @var mixed */
    public $customergroup;

    #[Rule('required', message: 'The name field cannot be empty.')]
    #[Rule('min:3', message: 'The name must be at least 3 characters.')]
    #[Rule('max:255', message: 'The name may not be greater than 255 characters.')]
    public $name;

    #[Rule('required', message: 'The percentage field cannot be empty.')]
    public $percentage;
    /** @var array */


    public function render()
    {
        // abort_if(Gate::denies('customer group edit'), 403);
        return view('livewire.admin.customer-group.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->customergroup = CustomerGroup::where('id', $id)->firstOrFail();

        $this->name = $this->customergroup->name;

        $this->percentage = $this->customergroup->percentage;
        
        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->customergroup->update(
            $this->all(),
        );

        $this->alert('success', __('Customer group Updated Successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }
}

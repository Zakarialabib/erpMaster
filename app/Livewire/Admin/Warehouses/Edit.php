<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Warehouses;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;

class Edit extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $editModal = false;

    public $warehouse;

    #[Rule('string|required|max:255')]
    public $name;
    #[Rule('numeric|nullable|max:255')]
    public $phone;
    #[Rule('nullable|max:255')]
    public $country;
    #[Rule('nullable|max:255')]
    public $city;
    #[Rule('nullable|max:255')]
    public $email;

    public function render()
    {
        return view('livewire.admin.warehouses.edit');
    }

    #[On('editModal')]
    public function editModal($id)
    {
        abort_if(Gate::denies('warehouse_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->warehouse = Warehouse::find($id);

        $this->name = $this->warehouse->name;

        $this->phone = $this->warehouse->phone;

        $this->country = $this->warehouse->country;

        $this->city = $this->warehouse->city;

        $this->email = $this->warehouse->email;

        $this->editModal = true;
    }

    public function update(): void
    {
        abort_if(Gate::denies('warehouse_update'), 403);

        $this->validate();

        $this->warehouse->save();

        $this->editModal = false;

        $this->alert('success', __('Warehouse updated successfully'));
    }
}

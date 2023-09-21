<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Shipping;

use App\Models\Shipping;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Shipping $shipping;

    public bool $is_pickup = false;

    #[Rule('required|max:255')]
    public string $title;

    #[Rule('nullable|max:255')]
    public string $subtitle;

    #[Rule('required|numeric')]
    public $cost;

    public function render()
    {
        abort_if(Gate::denies('shipping create'), 403);

        return view('livewire.admin.shipping.create');
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

        Shipping::create($this->all());

        $this->alert('success', __('Shipping created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;

        $this->reset(['title', 'subtitle', 'cost', 'is_pickup']);
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;

    public $editModal = false;

    /** @var mixed */
    public $currency;

    #[Rule('required', message: 'The name field cannot be empty.')]
    #[Rule('min:3', message: 'The name must be at least 3 characters.')]
    #[Rule('max:255', message: 'The name may not be greater than 255 characters.')]
    public $name;

    #[Rule('required', message: 'The code field cannot be empty.')]
    #[Rule('max:255', message: 'The code may not be greater than 255 characters.')]
    public $code;

    #[Rule('required', message: 'The symbol field cannot be empty.')]
    #[Rule('max:255', message: 'The symbol may not be greater than 255 characters.')]
    public $symbol;

    #[Rule('required', message: 'The exchange rate field cannot be empty.')]
    #[Rule('numeric', message: 'The exchange rate must be a number.')]
    public $exchange_rate;

    public function render()
    {
        abort_if(Gate::denies('currency_update'), 403);

        return view('livewire.admin.currency.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('currency create'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->currency = Currency::where('id', $id)->firstOrFail();

        $this->name = $this->currency->name;

        $this->code = $this->currency->code;

        $this->symbol = $this->currency->symbol;

        $this->exchange_rate = $this->currency->exchange_rate;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->currency->update(
            $this->all(),
        );

        $this->alert('success', __('Currency updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }
}

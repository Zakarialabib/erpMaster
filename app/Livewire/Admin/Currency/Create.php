<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Throwable;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Currency $currency;

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

    /** @var array */

    public function render()
    {
        abort_if(Gate::denies('currency create'), 403);

        return view('livewire.admin.currency.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        abort_if(Gate::denies('currency create'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->currency = Currency::create(
            $this->all()
        );

        $this->alert('success', __('Currency created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }
}

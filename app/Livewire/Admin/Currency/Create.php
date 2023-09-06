<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Currency $currency;

    /** @var array */
    protected $rules = [
        'currency.name'          => 'required|string|min:3|max:255',
        'currency.code'          => 'required|string|max:255',
        'currency.symbol'        => 'required|string|max:255',
        'currency.exchange_rate' => 'required|numeric',
    ];

    protected $messages = [
        'currency.name.required'          => 'The name field cannot be empty.',
        'currency.code.required'          => 'The code field cannot be empty.',
        'currency.symbol.required'        => 'The symbol field cannot be empty.',
        'currency.exchange_rate.required' => 'The exchange rate field cannot be empty.',
    ];

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
        $validatedData = $this->validate();

        try {
            $this->currency->save($validatedData);

            $this->alert('success', __('Currency created successfully.'));

            $this->dispatch('refreshIndex')->to(Index::class);

            $this->createModal = false;
        } catch (Throwable $th) {
            $this->alert('success', __('Error.').$th->getMessage());
        }
    }
}

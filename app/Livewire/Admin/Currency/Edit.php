<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class Edit extends Component
{
    use LivewireAlert;

    public $editModal = false;

    /** @var mixed */
    public $currency;

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

        $this->editModal = true;
    }

    public function update(): void
    {
        try {
            $validatedData = $this->validate();

            $this->currency->save($validatedData);

            $this->alert('success', __('Currency updated successfully.'));

            $this->dispatch('refreshIndex')->to(Index::class);

            $this->editModal = false;
        } catch (Throwable $th) {
            $this->alert('success', __('Error.').$th->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Currency;

use App\Models\Currency;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;

class Show extends Component
{
    public $showModal = false;

    public $currency;

    #[On('showModal')]
    public function showModal($id): void
    {
        abort_if(Gate::denies('currency_show'), 403);

        $this->currency = Currency::find($id);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.currency.show');
    }
}

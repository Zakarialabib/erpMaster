<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Attributes\On;

class Show extends Component
{
    public $sale;

    public $showModal = false;

    #[On('showModal')]
    public function showModal($id): void
    {
        $this->sale = Sale::findOrFail($id);

        $this->showModal = true;
    }

    public function render()
    {
        abort_if(Gate::denies('sale show'), 403);

        return view('livewire.admin.sales.show');
    }
}

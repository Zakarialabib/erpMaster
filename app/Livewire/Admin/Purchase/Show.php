<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Purchase;

use App\Models\Purchase;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $purchase;

    public $showModal = false;

    #[On('showModal')]
    public function showModal($id)
    {
        $this->purchase = Purchase::findOrFail($id);

        $this->showModal = true;
    }

    public function render()
    {
        // abort_if(Gate::denies('purchase show'), 403);

        return view('livewire.admin.purchase.show');
    }
}

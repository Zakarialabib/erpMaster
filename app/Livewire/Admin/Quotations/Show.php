<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Quotations;

use App\Models\Quotation;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    /** @var bool */
    public $showModal = false;

    public $quotation;

    public function render()
    {
        return view('livewire.admin.quotations.show');
    }

    #[On('showModal')]
    public function showModal($id)
    {
        abort_if(Gate::denies('quotation access'), 403);

        $this->quotation = Quotation::findOrFail($id);

        $this->showModal = true;
    }
}

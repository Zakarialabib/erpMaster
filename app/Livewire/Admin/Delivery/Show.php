<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Delivery;

use App\Models\Delivery;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class Show extends Component
{
    public $showModal = false;

    public $delivery;

    public function showModal($id)
    {
        // abort_if(Gate::denies('delivery_show'), 403);

        $this->delivery = Delivery::find($id);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.delivery.show');
    }
}

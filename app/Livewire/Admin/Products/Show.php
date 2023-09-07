<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $product;

    public $showModal = false;

    #[On('showModal')]
    public function showModal($id): void
    {
        $this->product = Product::findOrFail($id);

        $this->showModal = true;
    }

    public function render()
    {
        abort_if(Gate::denies('product show'), 403);

        return view('livewire.admin.products.show');
    }
}

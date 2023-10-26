<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class ThankYou extends Component
{
    //  show order description on thank you page

    public $order;

    public function mount($id): void
    {
        $this->order = Order::with('orderDetails')->findOrFail($id);
    }

    public function render(): View|Factory
    {
        return view('livewire.front.thank-you');
    }
}

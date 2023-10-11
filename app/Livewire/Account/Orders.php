<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Orders extends Component
{
    public $orders;

    public function mount($customer): void
    {
        $this->orders = Order::where('customer_id', $customer->id)->get();
    }

    public function render()
    {
        return view('livewire.account.orders');
    }
}

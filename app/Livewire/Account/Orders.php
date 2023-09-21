<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Orders extends Component
{
    public $orders;

    public function mount(): void
    {
        $user = User::find(Auth::user()->id);

        $this->orders = Order::where('customer_id', auth()->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.account.orders');
    }
}

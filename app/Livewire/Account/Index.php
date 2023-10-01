<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Index extends Component
{
    public $customer;

    public function mount(): void
    {
        $this->customer = auth()->guard('customer')->user();
    }

    public function render()
    {
        return view('livewire.account.index');
    }
}

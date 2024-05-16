<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Index extends Component
{
    public $customer;

    public function mount(): void
    {
        $this->customer = auth()->user();
    }

    public function render()
    {
        return view('livewire.account.index');
    }
}

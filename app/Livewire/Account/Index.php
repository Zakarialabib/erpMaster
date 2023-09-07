<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $user;

    public function mount(): void
    {
        $this->user = User::find(Auth::user()->id);
    }

    public function render()
    {
        return view('livewire.account.index');
    }
}

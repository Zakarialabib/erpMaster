<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Dashboard extends Component
{
    // public function mount()
    // {
    //     dd(auth());
    // }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

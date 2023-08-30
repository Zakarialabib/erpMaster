<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;

class Show extends Component
{
    public $user;

    /** @var bool */
    public $showModal = false;

    /** @var array<string> */
    public $listeners = [
        'showModal',
    ];

    public function showModal($id)
    {
        $this->user = User::find($id);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}

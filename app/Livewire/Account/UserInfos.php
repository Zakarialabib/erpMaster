<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserInfos extends Component
{
    use LivewireAlert;

    public $customer;

    public $email;

    #[Locked]
    public $password = '';

    public function mount($customer): void
    {
        $this->customer = $customer;
        // dd($this->customer);
        $this->email = $this->customer->email;
    }

    public function render()
    {
        return view('livewire.account.user-infos');
    }

    public function save(): void
    {
        if ($this->password !== '') {
            $this->password = bcrypt($this->password);
        }

        $this->customer->update([
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        $this->alert(
            'success',
            __('your account has been updated successfully!'),
            [
                'position'          => 'center',
                'timer'             => 3000,
                'toast'             => true,
                'text'              => '',
                'confirmButtonText' => 'Ok',
                'cancelButtonText'  => 'Cancel',
                'showCancelButton'  => false,
                'showConfirmButton' => false,
            ]
        );
    }
}

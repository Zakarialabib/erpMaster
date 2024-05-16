<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.guest')]
class Account extends Component
{
    use LivewireAlert;

    public $user;

    #[Validate('required', 'string', 'max:255')]
    public $name;

    #[Validate('required', 'لnumeric')]
    public $phone;

    #[Validate('required', 'string', 'email', 'max:255')]
    public $email;

    #[Validate('required', 'string', 'max:255')]
    public $address;

    #[Validate('required', 'string', 'max:255')]
    public $city;

    #[Validate('required', 'string', 'max:255')]
    public $country;

    public string $password = '';

    public function mount(): void
    {
        $this->user = User::find(Auth::id());
        $this->name = $this->user->name;
        $this->address = $this->user->address;
        $this->phone = $this->user->phone;
        $this->city = $this->user->city;
        $this->country = $this->user->country;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->password !== '') {
            $this->user->password = bcrypt($this->password);
        }

        $this->user->update();

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

    public function render()
    {
        return view('livewire.front.account');
    }
}

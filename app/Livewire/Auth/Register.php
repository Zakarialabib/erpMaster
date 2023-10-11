<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Enums\Status;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.guest')]
class Register extends Component
{
    #[Rule('required')]
    public $name = '';

    #[Rule('required|email|unique:users,email')]
    public $email = '';

    #[Rule('required')]
    public $password = '';

    #[Rule('required|min:8|same:passwordConfirmation')]
    public $passwordConfirmation = '';

    #[Rule('required|numeric')]
    public $phone;

    public $city;

    // Set the default city to 'Casablanca'
    public $country; // Set

    public function mount(): void
    {
        $this->city = 'Casablanca';
        $this->country = 'Morocco';
    }

    public function register()
    {
        $this->validate();

        $customer = Customer::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'phone'    => $this->phone,
            'city'     => $this->city,
            'country'  => $this->country,
            'status'   => Status::INACTIVE, // Set status to inactive by default
        ]);

        $role = Role::where('name', 'client')->first();

        if ( ! $role) {
            $role = Role::create([
                'guard_name' => 'customer',
                'name'       => 'client',
            ]);
        }

        $customer->assignRole($role);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer, true);

        $homePage = match (true) {
            $customer->hasRole('client') => '/my-account',
            default                      => '/',
        };

        return $this->redirect($homePage, navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}

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

    #[Rule('required', message: 'Email is required ')]
    #[Rule('email' , message :'Email must be valid')]
    #[Rule('unique:users,email')]
    public $email = '';

    #[Rule('required', message: 'Password is required')]
    public $password = '';

    #[Rule('required')]
    #[Rule('min:8')]
    #[Rule('same:passwordConfirmation')]
    public $passwordConfirmation = '';

    #[Rule('required')]
    #[Rule('numeric')]
    public $phone;

    public $city = 'Casablanca';

    public $country = 'Morocco'; 

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

        $role = Role::where('name', 'customer')->first();

        if ( ! $role) {
            $role = Role::create([
                'guard_name' => 'customer',
                'name'       => 'customer',
            ]);
        }

        $customer->assignRole($role);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer, true);

        $homePage = match (true) {
            $customer->hasRole('customer') => '/myaccount',
            default                      => '/',
        };

        return $this->redirect($homePage, navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    use LivewireAlert;

    #[Rule('required', message: 'Email is required ')]
    #[Rule('email', message: 'Email must be valid')]
    public $email;

    #[Rule('required', message: 'Password is required')]
    public $password;

    #[Rule('boolean')]
    public $remember_me = false;

    public function login()
    {
        $this->validate();


        if (auth()->guard('customer')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $customer = Customer::where(['email' => $this->email])->first();

            $customer->setRememberToken(Str::random(60));

            auth()->guard('customer')->login($customer, $this->remember_me);

            if ($customer->hasRole('vendor')) {
                $homePage = RouteServiceProvider::VENDOR_HOME;
            } else {
                $homePage = RouteServiceProvider::CLIENT_HOME;
            }

            // session()->regenerate();

            return $this->redirect(
                session('url.intended', $homePage),
                // navigate: true
            );
        }

        $this->alert('error', __('These credentials do not match our records'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

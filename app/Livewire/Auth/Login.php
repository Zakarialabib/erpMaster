<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    use LivewireAlert;

    #[Rule(['required', 'string', 'email'])]
    public string $email = '';

    #[Rule(['required', 'string'])]
    public string $password = '';

    #[Rule('boolean')]
    public $remember_me = false;

    public function authenticate()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $customer = Customer::where('email', $this->email)->first();

        if ($customer) {
            Auth::guard('customer')->login($customer, true);

            return redirect('myaccount');
        }

        $this->addError('status', 'Creadentials not found');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if ( ! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('Authentification throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

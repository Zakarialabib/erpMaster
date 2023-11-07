<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
    use LivewireAlert;

    #[Rule('required')]
    #[Rule('email')]
    public $email;

    #[Rule('required')]
    public $password;

    #[Rule('boolean')]
    public $remember_me = false;

    public function store()
    {
        $this->validate();

        $throttleKey = Str::transliterate(Str::lower($this->email) . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new Lockout(request()));

            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('Authentification throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        if (!auth()->attempt($this->only(['email', 'password'], $this->remember_me))) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('Authentification failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);

        session()->regenerate();

        $this->redirect(
            session('url.intended', RouteServiceProvider::ADMIN_HOME),
            navigate: true
        );

        $this->alert('error', __('These credentials do not match our records'));
    }


    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}

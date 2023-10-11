<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use App\Livewire\Admin\Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Login extends Component
{
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

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(['email' => $this->email])->first();

            auth()->login($user, $this->remember_me);

            if ($user->hasRole('admin')) {
                return $this->redirect(Dashboard::class);
            }
        }

        session()->regenerate();

        $this->redirect(
            session('url.intended', RouteServiceProvider::ADMIN_HOME),
            navigate: true
        );

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
        return view('livewire.admin.auth.login');
    }
}

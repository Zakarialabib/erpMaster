<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ConfirmPassword extends Component
{
    #[Rule(['required', 'string'])]
    public string $password = '';

    public function confirmPassword(): void
    {
        $this->validate();

        if ( ! auth()->guard('web')->validate([
            'email'    => auth()->user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('password'),
            ]);
        }

        session(['password confirmed at' => time()]);

        $this->redirect(
            session('url.intended', RouteServiceProvider::ADMIN_HOME),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.admin.auth.confirm-password');
    }
}

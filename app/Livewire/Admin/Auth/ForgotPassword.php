<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ForgotPassword extends Component
{
    /** @var string */
    public $email;

    /** @var string|null */
    public $emailSentMessage = false;

    public function sendResetPasswordLink(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $response = $this->broker()->sendResetLink(['email' => $this->email]);

        if ($response === Password::RESET_LINK_SENT) {
            $this->emailSentMessage = trans($response);

            return;
        }

        $this->addError('email', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    public function render()
    {
        return view('livewire.admin.auth.forgot-password');
    }
}

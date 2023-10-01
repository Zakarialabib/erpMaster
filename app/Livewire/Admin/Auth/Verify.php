<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Verify extends Component
{
    use LivewireAlert;

    public function sendVerification(): void
    {
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirect(
                session('url.intended', RouteServiceProvider::ADMIN_HOME),
                navigate: true
            );
            return;
        }
        auth()->user()->sendEmailVerificationNotification();
        session()->flash('status', 'verification-link-sent');
    }

    public function logout(): void
    {
        auth()->guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.auth.verify');
    }
}

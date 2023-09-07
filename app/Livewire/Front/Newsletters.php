<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Subscriber;
use App\Models\User;
use App\Mail\SubscribedMail;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Log;
use Throwable;

class Newsletters extends Component
{
    use LivewireAlert;

    public $newsletter;

    public $email;

    protected $listeners = [
        'submit',
    ];

    /* @var array */
    private function resetInputFields(): void
    {
        $this->email = '';
    }

    protected $rules = [
        'email' => 'required|email',
    ];

    public function render(): View|Factory
    {
        return view('livewire.front.newsletters');
    }

    public function subscribe(): void
    {
        try {
            $validatedData = $this->validate();

            Subscriber::create($validatedData);

            $this->alert('success', __('Your are subscribed to our newsletters.'));

            $this->resetInputFields();

            $user = User::find(1);

            $user_email = $user->email;

            Mail::to($user_email)->send(new SubscribedMail());
        } catch (Throwable $throwable) {
            $this->alert('error', __('Something went wrong. Please try again.'));
            Log::error($throwable->getMessage());
        }
    }
}

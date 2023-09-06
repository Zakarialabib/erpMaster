<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Mail\SubscribedMail;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;
use Livewire\Attributes\Rule;

class NewslettersForm extends Component
{
    use LivewireAlert;

    #[Rule('required|email')]
    public $email;

    public function render(): View|Factory
    {
        return view('livewire.front.newsletters-form');
    }

    public function subscribe()
    {
        try {
            $validatedData = $this->validate();

            Subscriber::create($validatedData);

            $this->alert('success', __('Your are subscribed to our newsletters.'));

            $this->reset('email');

            $user = User::find(1);

            $user_email = $user->email;

            Mail::to($user_email)->send(new SubscribedMail());
        } catch (Throwable $th) {
            $this->alert('error', __('Error').$th->getMessage());
        }
    }
}

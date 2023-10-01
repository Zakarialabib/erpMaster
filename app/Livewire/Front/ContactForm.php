<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Rule;

class ContactForm extends Component
{
    use LivewireAlert;

    public Contact $contact;

    #[Rule('required')]
    public $name;

    #[Rule('required|email')]
    public $email;

    #[Rule('required|numeric')]
    public $phone_number;

    #[Rule('required')]
    public $message;

    public function render()
    {
        return view('livewire.front.contact-form');
    }

    public function submit(): void
    {
        $this->validate();

        Contact::create($this->all());

        $this->alert('success', __('Your Message is sent succesfully.'));

        $this->reset(['name', 'email', 'phone_number', 'message']);

        $user = User::find(1);
        $user_email = $user->email;
        Mail::to($user_email)->send(new ContactFormMail($this->contact));
    }
}

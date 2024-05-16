<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Faq;

use App\Models\Faq;
use Illuminate\Contracts\View\Factory;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Faq $faq;

    #[Validate('required', message: 'The name field cannot be empty.')]
    #[Validate('min:3', message: 'The name must be at least 3 characters.')]
    #[Validate('max:255', message: 'The name may not be greater than 255 characters.')]
    public $name;

    #[Validate('required', message: 'The description field cannot be empty.')]
    public $description;

    public function render(): View|Factory
    {
        return view('livewire.admin.faq.create');
    }

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        Faq::create($this->all());

        $this->alert('success', __('Faq created successfully.'));

        $this->createModal = false;
    }
}

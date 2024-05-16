<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Faq;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Faq;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $faq;

    public $image;

    #[Validate('required|min:3|max:255', message: 'The name field cannot be empty.')]
    public $name;

    #[Validate('required', message: 'The percentage field cannot be empty.')]
    public $description;

    #[On('editModal')]
    public function editModal($faq): void
    {
        //abort_if(Gate::denies('category edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->faq = Faq::findOrFail($faq);

        $this->name = $this->faq->name;

        $this->description = $this->faq->description;
        $this->editModal = true;
    }

    public function update(): void
    {
        //abort_if(Gate::denies('faq edit'), 403);

        $this->validate();

        $this->faq->update(
            $this->all(),
        );

        $this->alert('success', __('Faq updated successfully.'));

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.faq.edit');
    }
}

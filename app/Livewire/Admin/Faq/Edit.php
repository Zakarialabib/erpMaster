<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Faq;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Faq;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $faq;

    public $image;

    protected $rules = [
        'faq.name'        => ['required', 'max:255'],
        'faq.description' => ['required'],
    ];

    #[On('editModal')]
    public function editModal($faq): void
    {
        //abort_if(Gate::denies('category edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->faq = Faq::findOrFail($faq);
        $this->editModal = true;
    }

    public function update(): void
    {
        //abort_if(Gate::denies('faq edit'), 403);

        $this->validate();

        $this->faq->save();

        $this->alert('success', __('Faq updated successfully.'));

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.faq.edit');
    }
}

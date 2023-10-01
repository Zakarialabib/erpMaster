<?php

declare(strict_types=1);

namespace App\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use App\Livewire\Utils\Admin\WithMeta;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;
    use WithMeta;

    public $blogcategory;

    #[Rule('required', message: 'Title is required')]
    public $title;

    #[Rule('min:3', message: 'Description must be at least 3 characters')]
    public $description;

    public $language_id;

    public $editModal = false;

    #[On('editModal')]
    public function editModal($id): void
    {
        // abort_if(Gate::denies('blogcategory edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->blogcategory = BlogCategory::where('id', $id)->firstOrFail();

        $this->title = $this->blogcategory->title;
        $this->description = $this->blogcategory->description;
        $this->meta_title = $this->blogcategory->meta_title;
        $this->meta_description = $this->blogcategory->meta_description;
        $this->editModal = true;
    }

    public function update(): void
    {
        $validated = $this->validate();

        $this->blogcategory->update($validated);

        $this->alert('success', __('BlogCategory updated successfully'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.blog-category.edit');
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal = false;

    public BlogCategory $blogcategory;

    #[Validate('required', message: 'Title is required')]
    #[Validate('min:3', message: 'Title must be at least 3 characters')]
    public $title;

    public $description;

    #[Validate('max:70', message: 'The meta title a max of 170 characters.')]
    public $meta_title;

    #[Validate('max:170', message: 'The meta description a max of 170 characters.')]
    public $meta_description;

    public $language_id;

    public function render()
    {
        abort_if(Gate::denies('blogcategory create'), 403);

        return view('livewire.admin.blog-category.create');
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

        BlogCategory::create([
            'title'            => $this->title,
            'description'      => $this->description,
            'language_id'      => 1,
            'meta_title'       => $this->title ?? '',
            'meta_description' => $this->description ?? '',
        ]);

        $this->alert('success', __('BlogCategory created successfully.'));

        $this->createModal = false;

        $this->dispatch('refreshIndex')->to(Index::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Livewire\Utils\Admin\WithMeta;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use WithMeta;

    public $createModal = false;

    public BlogCategory $blogcategory;

    #[Rule('required', message: 'Title is required')]
    #[Rule('min:3', message: 'Title must be at least 3 characters')]
    public $title;
    public $description;
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

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class Template extends Component
{
    use LivewireAlert;

    use WithFileUploads;

    public $templates = [];

    public $selectedTemplate = [];

    public $createModal;

    public $pages = [];

    public $selectTemplate;

    public $listeners = [
        'createModal',
    ];

    public function mount()
    {
        $this->templates = config('templates');
    }

    public function createModal()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function updatedSelectTemplate()
    {
        $this->selectedTemplate = $this->templates[$this->selectTemplate];
    }

    public function store()
    {
        try {
            $page = [
                'title'            => $this->selectedTemplate['title'],
                'slug'             => $this->selectedTemplate['slug'],
                'description'      => $this->selectedTemplate['description'],
                'meta_title'       => $this->selectedTemplate['meta_title'],
                'meta_description' => $this->selectedTemplate['meta_description'],
                'image'            => $this->selectedTemplate['image'],
            ];

            Page::create($page);

            $this->pages[] = $page;

            $this->dispatch('refreshIndex')->to(Index::class);

            $this->createModal = false;

            $this->alert('success', __('Page created successfully!'));
        } catch (Throwable) {
            $this->alert('warning', __('Page Was not created!'));
        }
    }

    public function render()
    {
        return view('livewire.admin.page.template');
    }
}

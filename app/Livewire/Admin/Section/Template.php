<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use App\Models\Section;
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

    public $createModal = false;

    public $sections = [];

    public $selectTemplate;

    public $description;

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

    public function create()
    {
        try {
            $section = [
                'title'          => $this->selectedTemplate['title'],
                'subtitle'       => $this->selectedTemplate['subtitle'],
                'featured_title' => $this->selectedTemplate['featured_title'],
                'label'          => $this->selectedTemplate['label'],
                'description'    => $this->description,
                'bg_color'       => $this->selectedTemplate['bg_color'],
                'position'       => $this->selectedTemplate['position'],
                'link'           => $this->selectedTemplate['link'],
            ];

            Section::create($section);

            $this->sections[] = $section;

            $this->dispatch('refreshIndex')->to(Index::class);

            $this->createModal = false;

            $this->alert('success', __('Section created successfully!'));
        } catch (Throwable) {
            $this->alert('warning', __('Section Was not created!'));
        }
    }

    public function render()
    {
        return view('livewire.admin.section.template');
    }
}

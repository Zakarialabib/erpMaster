<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use App\Models\Language;
use App\Models\Section;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public Section $section;

    public $image;
   
    #[Rule('required', message: 'Please provide a title')]
    #[Rule('min:3', message: 'This title is too short')]
    #[Rule('max:255', message: 'This title is too long')]
    public $title;

    #[Rule('nullable')]
    #[Rule('max:255', message: 'This subtitle is too long')]
    public $subtitle;

    #[Rule('nullable')]
    #[Rule('max:255', message: 'This featured title is too long')]
    public $featured_title;

    public $description;

    #[Rule('nullable|string|max:255 ')]
    public $link;

    #[Rule('nullable|string|max:255 ')]
    public $label;

    #[Rule('nullable')]
    public $bg_color;

    #[Rule('required|unique:sections,type')]
    public $type;

    #[Rule('nullable|integer')]
    public $page_id;

    public $text_color;

    public $embeded_video;

    public $createModal = false;

 
    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function render()
    {
        return view('livewire.admin.section.create');
    }

    public function save(): void
    {
        $this->validate();

        if ($this->image) {
            $imageName = Str::slug($this->title).'.'.$this->image->extension();
            $this->image->storeAs('sections', $imageName);
            $this->image = $imageName;
        }

        Section::create($this->all());

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Section created successfully!'));

        $this->createModal = false;
    }

    #[Computed]
    public function languages()
    {
        return Language::pluck('name', 'id')->toArray();
    }
}

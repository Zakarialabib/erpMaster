<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Section;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Language;
use App\Models\Page;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $section;

    #[Rule('required', message: 'The title is required')]
    #[Rule('max:255', message: 'The title must not exceed 255 characters')]
    public $title;


    #[Rule('max:255', message: 'The subtitle must not exceed 255 characters')]
    public $subtitle;


    #[Rule('min:3', message: 'The description must be at least 3 characters')]
    public $description;


    public $link;


    #[Rule('max:255', message: 'The label must not exceed 255 characters')]
    public $label;

    public $bg_color;


    #[Rule('integer')]
    #[Rule('exists:pages,id', 'The selected page does not exist')]
    public $page_id;

    #[Rule('required', message: 'The type is required')]
    #[Rule('max:255', message: 'The type must not exceed 255 characters')]
    public $type;


    #[Rule('max:255', message: 'The featured title must not exceed 255 characters')]
    public $featured_title;

    public $text_color;

    public $image;

    public $position;

    public $language_id;

    public $embeded_video;

    #[On('editModal')]
    public function editModal($id): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->section = Section::where('id', $id)->firstOrFail();

        $this->page_id = $this->section->page_id;
        $this->title = $this->section->title;
        $this->subtitle = $this->section->subtitle;

        $this->label = $this->section->label;
        $this->link = $this->section->link;

        $this->bg_color = $this->section->bg_color;

        $this->text_color = $this->section->text_color;

        $this->embeded_video = $this->section->embeded_video;
        $this->image = $this->section->image ?? '';

        $this->description = $this->section->description;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->section->title).'-'.Str::random(3).'.'.$this->image->extension();
            $this->image->storeAs('sections', $imageName);
            $this->section->image = $imageName;
        }

        $this->section->language_id = 1;
        $this->section->description = $this->description;

        $this->section->save();

        $this->alert('success', __('Section updated successfully!'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.section.edit');
    }

    #[Computed]
    public function languages()
    {
        return Language::pluck('name', 'id')->toArray();
    }
  
    #[Computed]
    public function pages()
    {
        return Page::select('title', 'id')->get();
    }
}

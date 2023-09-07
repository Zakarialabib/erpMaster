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

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $section;

    public $title = '';

    public $image;

    public $featured_title = '';

    public $subtitle = '';

    public $label = '';

    public string $link;

    public $description = '';

    public string $bg_color;

    public string $text_color;

    public string $page_id;

    public string $position;

    public $language_id;

    public $embeded_video;

    protected $rules = [
        'page_id'     => ['nullable'],
        'title'       => ['nullable', 'string', 'max:255'],
        'subtitle'    => ['nullable', 'string', 'max:255'],
        'description' => ['nullable'],
    ];

    #[On('editModal')]
    public function editModal($id)
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

    public function update()
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
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Slider;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Models\Slider;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $slider;

    #[Rule('required', message: 'Title is required')]
    public $title;

    #[Rule('nullable', 'max:255')]
    public $subtitle;

    #[Rule('nullable')]
    public $link;

    #[Rule('nullable')]
    public $bg_color;

    #[Rule('nullable')]
    public $embeded_video;

    public $image;

    #[Rule('nullable')]
    public $description;

    #[On('editModal')]
    public function editModal($id): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->slider = Slider::where('id', $id)->first();
        $this->title = $this->slider->title;
        $this->subtitle = $this->slider->subtitle;
        $this->link = $this->slider->link;
        $this->bg_color = $this->slider->bg_color;
        $this->embeded_video = $this->slider->embeded_video;

        $this->description = $this->slider->description;

        $this->image = $this->slider->image;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $imageName = Str::slug($this->slider->title).'-'.Str::random(5).'.'.$this->image->extension();
            $this->image->storeAs('public/sliders', $imageName);
            $this->slider->image = $imageName;
        }

        $this->slider->language_id = 1;
        $this->slider->description = $this->description;

        $this->slider->save();

        $this->alert('success', __('Slider updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.slider.edit');
    }
}

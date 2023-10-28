<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Slider;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
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


    public $link;


    public $bg_color;


    public $embeded_video;

    public $image;


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

        if (!$this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $path = public_path() . '/images/sliders/' . basename((string) $this->image);
            Storage::delete($path);

            $fileName = Str::slug($this->title) . '.' . $this->image->extension();
            $this->image->storeAs('sliders', $fileName, 'local_files');
            $this->image = $fileName;
        }

        $this->slider->language_id = 1;
        $this->slider->description = $this->description;

        $this->slider->update(
            $this->all(),
        );

        $this->alert('success', __('Slider updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.slider.edit');
    }
}

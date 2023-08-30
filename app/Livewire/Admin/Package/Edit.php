<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Package;

use App\Models\Package;
use App\Models\Activity;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $package;
    public $editModal = false;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $price;
    public $image;
    public $gallery;
    #[Rule('required|array')]
    public $activities;

    #[On('editModal')]
    public function editModal($id)
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->package = Package::where('id', $id)->firstOrFail();

        $this->name = $this->package->name;

        $this->description = $this->package->description;

        $this->price = $this->package->price;

        $this->image = $this->package->image;

        $this->gallery = $this->package->gallery;

        $this->activities = json_decode($this->package->activities);

        $this->editModal = true;
    }

    public function update()
    {
        $this->validate();

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $fileName = Str::slug($this->name).'.'.$this->image->extension();
            $this->image->storeAs('packages', $fileName, 'local_files');
            $this->image = $fileName;
        }

        $this->package->update([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'image'       => $this->image,
            // 'gallery'     => $this->gallery,
            'activities' => json_encode($this->activities),
        ]);

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Package updated successfully.'));

        $this->editModal = false;
    }

    #[Computed]
    public function allActivities()
    {
        return Activity::active()->pluck('name', 'id')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.package.edit');
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Package;

use App\Models\Package;
use App\Models\Activity;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

class Create extends Component
{
    use LivewireAlert;

    public Package $package;
    public $createModal = false;

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

    #[On('createModal')]
    public function createModal()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function store()
    {
        $this->validate();

        if ( ! $this->image) {
            $this->image = null;
        } elseif (is_object($this->image) && method_exists($this->image, 'extension')) {
            $fileName = Str::slug($this->name).'.'.$this->image->extension();
            $this->image->storeAs('packages', $fileName, 'local_files');
            $this->image = $fileName;
        }

        Package::create([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'image'       => $this->image,
            // 'gallery'     => $this->gallery,
            'activities' => json_encode($this->activities),
        ]);

        // dd($this->all());

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', __('Activity updated successfully.'));

        $this->createModal = false;
    }

    public function updatedActivities($value)
    {
        $this->activities = $value;
        // dd($this->activities);
    }

    #[Computed]
    public function allActivities()
    {
        return Activity::active()->pluck('name', 'id')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.package.create');
    }
}

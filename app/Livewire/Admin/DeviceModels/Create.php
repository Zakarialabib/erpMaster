<?php

declare(strict_types=1);

namespace App\Livewire\Admin\DeviceModels;

use App\Models\DeviceModel;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal;

    public $device_model;

    public $listeners = ['createModal'];

    public $image;

    public $description;

    protected $rules = [
        'device_model.name'              => ['required', 'string', 'max:255'],
        'device_model.slug'              => ['required', 'string', 'max:255'],
        'device_model.code'              => ['nullable', 'string', 'max:255'],
        'device_model.technical_details' => ['nullable', 'array'],
        'device_model.features'          => ['nullable', 'array'],
        'device_model.specifications'    => ['nullable', 'array'],
        'device_model.type'              => ['nullable', 'string', 'max:255'],
        'device_model.brand_id'          => ['required', 'exists:brands,id'],
        'image'                          => ['nullable', 'image', 'max:1024'],
        'description'                    => ['nullable', 'string'],
    ];

    public function render(): View|Factory
    {
        // abort_if(Gate::denies('device_model_create'), 403);

        return view('livewire.admin.device-models.create');
    }

    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->device_model = new DeviceModel();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->device_model->slug = Str::slug($this->device_model->name);

        if ($this->image_url) {
            $image = file_get_contents($this->image_url);

            $imageName = Str::random(5).'.'.$this->image->extension();
            $width = 500;
            $height = 500;

            $img = Image::make($this->image->getRealPath())->encode('webp', 85);

            // we need to resize image, otherwise it will be cropped
            if ($img->width() > $width) {
                $img->resize($width, null, function ($constraint): void {
                    $constraint->aspectRatio();
                });
            }

            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint): void {
                    $constraint->aspectRatio();
                });
            }

            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');

            $img->stream();

            Storage::disk('local_files')->put('device-models/'.$imageName, $img, 'public');

            $this->device_model->image = $imageName;
        }

        if ($this->image) {
            // with str slug with name date
            $imageName = Str::slug($this->device_model->name).'.'.$this->image->extension();
            $width = 500;
            $height = 500;

            $img = Image::make($this->image->getRealPath())->encode('webp', 85);

            // we need to resize image, otherwise it will be cropped
            if ($img->width() > $width) {
                $img->resize($width, null, function ($constraint): void {
                    $constraint->aspectRatio();
                });
            }

            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint): void {
                    $constraint->aspectRatio();
                });
            }

            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');

            $img->stream();

            Storage::disk('local_files')->put('device-models/'.$imageName, $img, 'public');

            $this->device_model->image = $imageName;
        }

        $this->device_model->description = $this->description;

        $this->device_model->save();

        $this->emit('refreshIndex');

        $this->alert('success', __('DeviceModel created successfully.'));

        $this->createModal = false;
    }
}

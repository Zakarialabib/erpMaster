<?php

declare(strict_types=1);

namespace App\Livewire\Admin\DeviceModels;

use App\Models\DeviceModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;

class Edit extends Component
{
    public $device_model;

    public $editModal = false;

    public $listeners = [
        'editModal',
    ];

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

    public function updatedDescription($value): void
    {
        $this->description = $value;
    }

    public function getImagePreviewProperty()
    {
        return $this->device_model?->image;
    }

    public function editModal($device_model): void
    {
        // abort_if(Gate::denies('device_model_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->device_model = DeviceModel::findOrfail($device_model);

        $this->description = $this->device_model->description;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        if ($this->image) {
            $imageName = Str::slug($this->device_model->name).'-'.Str::random(5).'.'.$this->image->extension();
            $width = 500;
            $height = 500;

            $img = Image::make($this->image->getRealPath())->encode('webp', 85);

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

        $this->alert('success', __('DeviceModel updated successfully.'));

        $this->emit('refreshIndex');

        $this->editModal = false;
    }

    public function render(): View
    {
        return view('livewire.admin.device-models.edit');
    }
}

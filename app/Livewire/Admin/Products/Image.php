<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageIntervention;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $product;

    public $image;

    public $image_url;

    public $embeded_video;

    public $gallery = [];

    public $listeners = [
        'imageModal', 'saveImage',
    ];

    public $imageModal = false;

    public $width = 1000;

    public $height = 1000;

    public function imageModal($id): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->product = Product::findOrFail($id);

        $this->imageModal = true;
    }

    public function saveImage(): void
    {
        try {
            if ($this->image_url) {
                $image = file_get_contents($this->image_url);
                $imageName = Str::random(10).'.jpg';
                Storage::disk('local_files')->put('products/'.$imageName, $image, 'public');
                $this->product->image = $imageName;
            }

            if ($this->embeded_video) {
                $this->product->image = $this->embeded_video;
            }

            if ($this->image) {
                $imageName = Str::slug($this->product->name).'-'.Str::random(5).'.jpg'.$this->image->extension();

                $img = ImageIntervention::make($this->image->getRealPath())->encode('webp', 85);

                // we need to resize image, otherwise it will be cropped
                if ($img->width() > $this->width) {
                    $img->resize($this->width, null, static function ($constraint): void {
                        $constraint->aspectRatio();
                    });
                }

                if ($img->height() > $this->height) {
                    $img->resize(null, $this->height, static function ($constraint): void {
                        $constraint->aspectRatio();
                    });
                }

                $img->resizeCanvas($this->width, $this->height, 'center', false, '#ffffff');

                $img->stream();

                Storage::disk('local_files')->put('products/'.$imageName, $img, 'public');

                $this->product->image = $imageName;
            }

            // gallery image
            if ($this->gallery) {
                $gallery = [];

                foreach ($this->gallery as $key => $value) {
                    $image = $value;
                    $imageName = Str::slug($this->product->name).'-'.$key.'.'.$value->extension();

                    $img = ImageIntervention::make($image->getRealPath())->encode('webp', 85);

                    // we need to resize image, otherwise it will be cropped
                    if ($img->width() > $this->width) {
                        $img->resize($this->width, null, static function ($constraint): void {
                            $constraint->aspectRatio();
                        });
                    }

                    if ($img->height() > $this->height) {
                        $img->resize(null, $this->height, static function ($constraint): void {
                            $constraint->aspectRatio();
                        });
                    }

                    $img->resizeCanvas($this->width, $this->height, 'center', false, '#ffffff');

                    $img->stream();
                    Storage::disk('local_files')->put('products/'.$imageName, $img, 'public');
                    $gallery[] = $imageName;
                }

                $this->product->gallery = json_encode($gallery, JSON_THROW_ON_ERROR);
            }

            $this->product->save();

            $this->alert('success', __('Product image updated successfully.'));

            $this->imageModal = false;
        } catch (Exception) {
            $this->alert('warning', __('Product image was not updated.'));
        }
    }

    public function render(): View|Factory
    {
        return view('livewire.admin.products.image');
    }
}

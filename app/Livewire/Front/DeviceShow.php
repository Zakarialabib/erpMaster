<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DeviceShow extends Component
{
    use LivewireAlert;

    public $product;

    public $device_model;

    public $relatedProducts;

    public $similarProducts;

    public $brand;

    public $brand_device_models;

    public $listeners = [
    ];

    public function mount($slug): void
    {
        $this->device_model = DeviceModel::whereSlug($slug)->first();

        $this->brand_device_models = DeviceModel::active()
            ->where('brand_id', $this->device_model->brand_id)
            ->limit(4)->get();

        $this->similarProducts = Product::where('name', 'like', '%'.$this->device_model->name.'%')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $this->relatedProducts = Product::active()
            ->where('brand_id', $this->device_model->brand_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $this->brand = Brand::where('id', $this->device_model->brand_id)->first();
    }

    public function render(): View|Factory
    {
        return view('livewire.front.device-show');
    }
}

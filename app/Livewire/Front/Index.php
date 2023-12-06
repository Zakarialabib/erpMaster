<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\FeaturedBanner;
use App\Models\Product;
use App\Models\Section;
use App\Models\Slider;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.guest')]
class Index extends Component
{
    #[Computed]
    public function subcategories(): Collection
    {
        return Subcategory::inRandomOrder()->limit(3)->get();
    }

    public function getFeaturedProductsProperty()
    {
        return Product::ecommerceProducts()
            ->where('featured', 1)
            ->active()
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getBestOffersProperty()
    {
        return Product::ecommerceProducts()
            ->where('best', 1)
            ->active()
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getHotProductsProperty()
    {
        return Product::ecommerceProducts();
    }

    public function getBrandsProperty(): Collection
    {
        return Brand::with('products')->get();
    }

    public function getSlidersProperty(): Collection
    {
        return Slider::active()->get();
    }

    public function getFeaturedbannerProperty()
    {
        return FeaturedBanner::where('featured', 1)->first();
    }

    public function getSectionsProperty(): Collection
    {
        return Section::active()->limit(4)->get();
    }

    public function render(): View|Factory
    {
        return view('livewire.front.index');
    }
}

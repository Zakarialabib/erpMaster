<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Brand;
use App\Models\FeaturedBanner;
use App\Models\Section;
use App\Models\Slider;
use App\Models\Subcategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class Index extends Component
{
    public function getSubcategoriesProperty(): Collection
    {
        return Subcategory::inRandomOrder()->limit(3)->get();
    }

    public function getFeaturedProductsProperty()
    {
        return \App\Helpers::getEcommerceProducts()
            ->where('featured', 1)
            ->active()
            ->inRandomOrder()
            ->limit(4);
        // dd($query);
    }

    public function getBestOffersProperty()
    {
        return \App\Helpers::getEcommerceProducts()
            ->where('best', 1)
            ->active()
            ->inRandomOrder()
            ->limit(4);
    }

    public function getHotProductsProperty()
    {
        return \App\Helpers::getEcommerceProducts()
            ->where('hot', 1)
            ->active()
            ->inRandomOrder()
            ->limit(4);
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

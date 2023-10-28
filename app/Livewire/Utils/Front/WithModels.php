<?php

declare(strict_types=1);

namespace App\Livewire\Utils\Front;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;

trait WithModels
{
    public $selectCount = 10;

    #[Computed(cache: true)]
    public function categories()
    {
        return Category::select('id', 'name', 'slug', 'image')
            ->get();
    }

    #[Computed(cache: true)]
    public function brands()
    {
        return Brand::select('id', 'name', 'slug', 'image')
            ->get();
    }

    #[Computed(cache: true)]
    public function subcategories()
    {
        return Subcategory::select('id', 'name', 'slug', 'image')
            ->get();
    }
}

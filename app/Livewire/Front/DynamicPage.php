<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Enums\PageType;
use App\Models\Page;
use App\Models\Slider;
use App\Models\Section;
use App\Models\Category;
use App\Models\PageSetting;
use Livewire\Component;
use App\Traits\LazySpinner;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class DynamicPage extends Component
{
    use LazySpinner;

    public Page $page;

    public $description;

    public $type;

    public $tag;

    public $pageSetting;

    public $settings;

    public $pageType;

    public $item_id;

    public $layout_config;

    public function mount(?string $slug = 'home'): void
    {
        $this->page = Page::where('slug', $slug)->firstOrFail();
        $this->type = $this->page->type;
        $this->description = $this->page->description;

        if (is_string($this->page->settings)) {
            $this->settings = json_decode((string) $this->page->settings, true);
        } elseif (is_array($this->page->settings)) {
            $this->settings = $this->page->settings;
        }

        $this->pageSetting = PageSetting::where('page_id', $this->page->id)
            ->first();

        if ( ! $this->pageSetting) {
            return;
        }

        if ( ! $this->pageSetting->layout_config) {
            return;
        }

        $this->layout_config = json_decode((string) $this->pageSetting->layout_config, true);
    }

    #[Computed]
    public function sliders()
    {
        return Slider::active()->take(5)->get();
    }

    #[Computed]
    public function categories()
    {
        return Category::inRandomOrder()->get();
    }

    #[Computed]
    public function sections()
    {
        return Section::active()->where('type', PageType::HOME)->get();
    }

    #[Computed]
    public function featuredProducts()
    {
        return \App\Helpers::getEcommerceProducts()
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    #[Computed]
    public function aboutSection()
    {
        $page = Page::where('type', PageType::ABOUT)->first();

        return Section::where('page_id', $page->id)->active()->first();
    }

    #[Computed]
    public function contactSection()
    {
        $page = Page::where('type', PageType::CONTACT)->first();

        return Section::where('page_id', $page->id)->active()->first();
    }

    public function render()
    {
        return view('livewire.front.dynamic-page');
    }
}

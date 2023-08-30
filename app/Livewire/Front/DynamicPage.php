<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Enums\PageType;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\Section;
use Livewire\Component;
use App\Traits\LazySpinner;
use Livewire\Attributes\Computed;

class DynamicPage extends Component
{
    use LazySpinner;
    public Page $page;
    public $section;
    public string $description;
    public string $type;
    public int $is_sliders;

    public function mount(?string $slug = 'home')
    {
        $this->page = Page::where('slug', $slug)->firstOrFail();

        $this->section = Section::where('type', $this->page->type)
            ->where('page_id', $this->page->id)
            ->first();
        $this->type = $this->page->type;
        $this->description = $this->page->description;
        $this->is_sliders = $this->page->is_sliders;
    }

    #[Computed]
    public function sliders()
    {
        return Slider::active()->take(5)->get();
    }

    #[Computed]
    public function partners()
    {
        return Partner::active()->get();
    }

    #[Computed]
    public function outdoorActivity()
    {
        $page = Page::where('type', PageType::ACTIVITY)->first();

        return Section::where('page_id', $page->id)->active()->first();
    }

    #[Computed]
    public function workshopActivity()
    {
        $page = Page::where('type', PageType::WORKSHOP)->first();

        return Section::where('page_id', $page->id)->active()->first();
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

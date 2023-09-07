<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Page;

use Livewire\Component;
use App\Models\PageSetting;
use App\Models\Section;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

#[Layout('components.layouts.dashboard')]
class Settings extends Component
{
    use LivewireAlert;
    use WithPagination;

    public PageSetting $setting;

    public bool $is_sliders = false;

    public bool $is_contact = false;

    public bool $is_offer = false;

    public bool $is_partners = false;

    public bool $is_title = true;

    public bool $is_description = true;

    public bool $is_package = false;

    public bool $is_visible = true;

    public bool $darkMode = false;

    public $colorOptions = [];

    public $colors;

    public $selectedColor;


    public $section_order;

    public $bg_color;

    public $text_color;

    public $font_size;

    public $custom_properties = [];

    public $status;

    #[Rule('nullable')]
    public $page_id;


    public function render()
    {
        $settings = PageSetting::orderBy('section_order')->paginate(10);
        return view('livewire.admin.page.settings', ['settings' => $settings]);
    }

    public $selectedTemplate;

    public $sectionTemplates;

    public function mount()
    {
        // Load section templates from the database
        $this->sectionTemplates = Section::all();
        $this->colors = ['gray', 'red', 'green', 'blue', 'indigo'];
        $this->colorOptions = [100, 200, 300, 400, 500, 600, 700, 800, 900];
    }

    public function selectedColor($color)
    {
        $this->bg_color = $color;
    }

    public function selectedBgColor($color)
    {
        $this->bg_color = $color;
    }

    public function applyTemplate()
    {
        if ($this->selectedTemplate) {
            $template = Section::find($this->selectedTemplate);
            $newPreviewContent = $template->preview_content;
            $this->dispatch('updatePreview', $newPreviewContent);
        }
    }

    public function updateSectionOrder($newSectionOrder)
    {
        // Update the section order in the database
        foreach ($newSectionOrder as $section) {
            $sectionToUpdate = PageSetting::find($section['value']);
            $sectionToUpdate->update(['section_order' => $section['order']]);
        }

        // Emit an event to notify the JavaScript that the order is updated
        $this->dispatch('sectionOrderUpdated');
    }

    public function create()
    {
        $this->setting = new PageSetting();
        $this->section_order = $this->settings->max('section_order') + 1;
    }

    public function edit(PageSetting $setting)
    {
        $this->setting = $setting;
    }

    public function save()
    {
        $this->validate();

        if ($this->setting->id) {
            $this->setting->update($this->all());
        } else {
            PageSetting::create($this->all());
        }

        $this->alert('success', 'Page setting successfully saved.');

        $this->resetForm();
    }

    public function delete(PageSetting $setting)
    {
        $setting->delete();
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->setting = null;
        $this->resetValidation();
        $this->reset();
    }
}

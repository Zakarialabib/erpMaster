<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Section;

use App\Models\PageSetting;
use App\Models\Section;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Layout('components.layouts.dashboard')]
class Settings extends Component
{
    use LivewireAlert;
    public $colors = ['gray', 'red', 'green', 'blue', 'indigo'];

    #[Rule('nullable')]
    public $bg_color;

    public $text_color;

    public $sectionSetting;

    #[Rule('nullable')]
    public $section_id;

    public $colorOptions = [100, 200, 300, 400, 500, 600, 700, 800, 900];

    public $fontSizes = ['xs', 'sm', 'base', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '9xl'];

    public $layout_type = 'row';

    public $layoutTypes = ['row', 'col'];

    public $layout_config = [];

    public $section = '';

    public $selectedSectionId;

    public $selectedTemplate;

    public $sizing;

    protected $rules = [
        'layout_config.type'                        => '',
        'layout_config.item_config.status'          => '',
        'layout_config.item_config.title'           => '',
        'layout_config.item_config.description'     => '',
        'layout_config.item_config.link'            => '',
        'layout_config.item_config.icon'            => '',
        'layout_config.item_config.parallax'        => '',
        'layout_config.item_style.status'           => '',
        'layout_config.item_style.width'            => '',
        'layout_config.item_style.height'           => '',
        'layout_config.item_style.background_color' => '',
        'layout_config.item_style.text_color'       => '',
        'layout_config.item_style.font_size'        => '',
        'layout_config.item_style.padding'          => '',
        'layout_config.item_style.margin'           => '',
        'layout_config.item_style.border'           => '',
        'layout_config.item_style.border.width'     => '',
        'layout_config.item_style.border.color'     => '',
        'layout_config.item_style.border.style'     => '',
        'layout_config.item_style.border_radius'    => '',
        'layout_config.item_style.box_shadow'       => '',
    ];

    public function updatedSectionId(): void
    {
        if ($this->section_id) {
            $this->section = Section::find($this->section_id);

            $this->sectionSetting = PageSetting::where('section_id', $this->section_id)->first();

            if ($this->sectionSetting) {
                $this->layout_config = json_decode($this->sectionSetting->layout_config, true);
            }
        }
    }

    public function mount()
    {
        $this->sectionSetting = PageSetting::where('section_id', $this->section_id)->first();

        if ($this->sectionSetting) {
            $this->fill([
                'layout_config' => json_decode($this->sectionSetting->layout_config, true),
                // 'type'          => $this->pageSetting->type,
            ]);

            // $this->layout_config = json_decode($this->sectionSetting->layout_config, true);
        }
    }

    #[Computed]
    public function sections()
    {
        return Section::select('id', 'title')->get();
    }

    public function save(): void
    {
        $this->validate([
            // 'page_id'           => 'required',
            'section_id'  => 'required',
            'layout_type' => 'required',
        ]);

        if ($this->selectedTemplate) {
            $selectedTemplateStyles = $this->getSelectedTemplateStyles($this->selectedTemplate);

            $newSection = [
                'type'        => 'section',
                'item_config' => [
                    'status'      => false,
                    'title'       => '',
                    'description' => '',
                    'link'        => '',
                    'icon'        => '',
                    'parallax'    => '',
                ],
                'item_style' => $selectedTemplateStyles,
            ];
        } else {
            $newSection = [
                'type'        => 'section',
                'item_config' => [
                    'status'      => false,
                    'title'       => '',
                    'description' => '',
                    'link'        => '',
                    'icon'        => '',
                    'parallax'    => '',
                ],
                'item_style' => [
                    'status'           => true,
                    'width'            => $this->sizing,
                    'height'           => '',
                    'background_color' => $this->bg_color,
                    'text_color'       => '',
                    'font_size'        => '',
                    'padding'          => '',
                    'margin'           => '',
                    'border'           => [
                        'width' => '',
                        'color' => '',
                        'style' => '',
                    ],
                    'border_radius' => '',
                    'box_shadow'    => '',
                ],
            ];
        }

        $this->sectionSetting = PageSetting::updateOrCreate(
            ['section_id' => $this->section_id],
            [
                'section_id'  => $this->section_id,
                'status'      => true,
                'layout_type' => $this->layout_type,
                // 'layout_config' => json_encode(),
            ]
        );

        $this->sectionSetting->layout_config = json_encode($newSection);

        $this->sectionSetting->save();

        $this->mount();

        if ($this->sectionSetting) {
            $this->alert('success', 'Page setting successfully saved.');
        } else {
            $this->alert('error', 'Failed to save page setting.');
        }
    }

    private function getSelectedTemplateStyles($templateName)
    {
        $templates = $this->templates;

        if (isset($templates[$templateName])) {
            return $templates[$templateName]['styles'];
        }

        return [];
    }

    #[Computed]
    public function templates(): array
    {
        // get template in array format with index as template name
        return [
            [
                'name'   => 'Hero Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '100',
                    'height'           => '100',
                    'background_color' => 'blue',
                    'text_color'       => 'white',
                    'font_size'        => '24',
                    'padding'          => '20',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '2',
                        'color' => 'black',
                        'style' => 'solid',
                    ],
                    'border_radius' => '0',
                    'box_shadow'    => 'none',
                ],
            ],
            [
                'name'   => 'Card Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '100',
                    'height'           => '100',
                    'background_color' => 'white',
                    'text_color'       => 'black',
                    'font_size'        => '16',
                    'padding'          => '10',
                    'margin'           => '10',
                    'border'           => [
                        'width' => '1',
                        'color' => 'gray',
                        'style' => 'solid',
                    ],
                    'border_radius' => '5',
                    'box_shadow'    => '0px 2px 4px rgba(0, 0, 0, 0.1)',
                ],
            ],
            [
                'name'   => 'Feature Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '100',
                    'height'           => '100',
                    'background_color' => 'lightgray',
                    'text_color'       => 'black',
                    'font_size'        => '18',
                    'padding'          => '20',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '2',
                        'color' => 'blue',
                        'style' => 'solid',
                    ],
                    'border_radius' => '10',
                    'box_shadow'    => '0px 4px 8px rgba(0, 0, 0, 0.2)',
                ],
            ],
            [
                'name'   => 'Banner Section',
                'styles' => [
                    'status'           => true,
                    'width'            => 'full',
                    'height'           => '300',
                    'background_color' => 'green',
                    'text_color'       => 'white',
                    'font_size'        => '24',
                    'padding'          => '20',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '0',
                        'color' => 'transparent',
                        'style' => 'none',
                    ],
                    'border_radius' => '0',
                    'box_shadow'    => 'none',
                ],
            ],
            [
                'name'   => 'Testimonial Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '100',
                    'height'           => '100',
                    'background_color' => 'lightblue',
                    'text_color'       => 'black',
                    'font_size'        => '18',
                    'padding'          => '20',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '1',
                        'color' => 'gray',
                        'style' => 'solid',
                    ],
                    'border_radius' => '5',
                    'box_shadow'    => '0px 2px 4px rgba(0, 0, 0, 0.1)',
                ],
            ],
            [
                'name'   => 'Feature Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '100',
                    'height'           => '100',
                    'background_color' => 'lightgray',
                    'text_color'       => 'black',
                    'font_size'        => '20',
                    'padding'          => '30',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '1',
                        'color' => 'darkgray',
                        'style' => 'solid',
                    ],
                    'border_radius' => '10',
                    'box_shadow'    => '0px 4px 8px rgba(0, 0, 0, 0.2)',
                ],
            ],
            [
                'name'   => 'Sidebar Section',
                'styles' => [
                    'status'           => true,
                    'width'            => '25',
                    'height'           => '100',
                    'background_color' => '',
                    'text_color'       => 'black',
                    'font_size'        => '20',
                    'padding'          => '0',
                    'margin'           => '0',
                    'border'           => [
                        'width' => '1',
                        'color' => 'darkgray',
                        'style' => 'solid',
                    ],
                    'border_radius' => '0',
                    'box_shadow'    => 'none',
                ],
            ],

        ];
    }

    public function render()
    {
        return view('livewire.admin.section.settings');
    }

    // $padding = [
    //     'top'    => $this->layout_config['item_style']['padding']['top'],
    //     'bottom' => $this->layout_config['item_style']['padding']['bottom'],
    //     'left'   => $this->layout_config['item_style']['padding']['left'],
    //     'right'  => $this->layout_config['item_style']['padding']['right'],
    // ];

    // $margin = [
    //     'top'    => $this->layout_config['item_style']['margin']['top'],
    //     'bottom' => $this->layout_config['item_style']['margin']['bottom'],
    //     'left'   => $this->layout_config['item_style']['margin']['left'],
    //     'right'  => $this->layout_config['item_style']['margin']['right'],
    // ];
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Language;

use Livewire\Component;
use App\Models\Language;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditTranslation extends Component
{
    use LivewireAlert;
    public $language;

    public $translations;

    public $rules = [
        'translations.*.value' => 'required',
    ];

    public function mount($language)
    {
        $this->language = Language::where('id', $language)->firstOrFail();
        // dd($this->all());
        $this->translations = $this->getTranslations();
        $this->translations = collect($this->translations)->map(static fn($item, $key) => [
            'key'   => $key,
            'value' => $item,
        ])->toArray();
    }

    private function getTranslations()
    {
        $path = base_path(sprintf('lang/%s.json', $this->language->code));
        $content = file_get_contents($path);

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    public function updateTranslation()
    {
        $this->validate();

        $path = base_path(sprintf('lang/%s.json', $this->language->code));

        $data = file_get_contents($path);
        $translations = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        foreach ($this->translations as $translation) {
            $translations[$translation['key']] = $translation['value'];
        }

        file_put_contents($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->alert('success', __('Data created successfully!'));
    }

    public function render()
    {
        return view('livewire.admin.language.edit-translation');
    }
}

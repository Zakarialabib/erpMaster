<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Language;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    public array $languages = [];

    public $language;

    public $name;

    public $code;

    public $editLanguage = false;

    protected $rules = [
        'language.name' => 'required|max:191',
        'language.code' => 'required',
    ];

    #[On('editLanguage')]
    public function editLanguage($id): void
    {
        $this->language = Language::findOrFail($id);

        $this->editLanguage = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->language->save();

        File::copy(App::langPath() . ('/en.json'), App::langPath() . ('/' . $this->code . '.json'));

        $this->alert('success', __('Data created successfully!'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editLanguage = false;
    }

    public function render()
    {
        return view('livewire.admin.language.edit');
    }
}

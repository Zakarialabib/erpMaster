<?php

declare(strict_types=1);

namespace App\Livewire\Admin\FeaturedBanner;

use App\Models\FeaturedBanner;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $createModal = false;

    public $image;

    public FeaturedBanner $featuredbanner;

    public array $listsForFields = [];

    protected $rules = [
        'featuredbanner.title'         => ['required', 'string', 'max:255'],
        'featuredbanner.description'   => ['nullable', 'string'],
        'featuredbanner.link'          => ['nullable', 'string'],
        'featuredbanner.product_id'    => ['nullable', 'integer'],
        'featuredbanner.language_id'   => ['nullable', 'integer'],
        'featuredbanner.embeded_video' => ['nullable'],
    ];

    public function mount()
    {
        $this->initListsForFields();
    }

    public function render(): View|Factory
    {
        abort_if(Gate::denies('featuredbanner create'), 403);

        return view('livewire.admin.featured-banner.create');
    }

    public function createModal()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create()
    {
        $this->validate();

        if ($this->image) {
            $imageName = Str::slug($this->featuredbanner->title).'-'.Str::random(3).'.'.$this->image->extension();
            $this->image->storeAs('featuredbanners', $imageName);
            $this->featuredbanner->image = $imageName;
        }

        $this->featuredbanner->save();

        $this->alert('success', __('FeaturedBanner created successfully.'));

        $this->createModal = false;
    }

    public function initListsForFields()
    {
        $this->listsForFields['languages'] = Language::pluck('name', 'id')->toArray();
        $this->listsForFields['products'] = Product::pluck('name', 'id')->toArray();
    }
}

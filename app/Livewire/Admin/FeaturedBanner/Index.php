<?php

declare(strict_types=1);

namespace App\Livewire\Admin\FeaturedBanner;

use App\Models\FeaturedBanner;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Utils\Datatable;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;
    use WithFileUploads;
    public $featuredbanner;

    public $model = FeaturedBanner::class;

    public $image;

    public $listeners = [
        'showModal',
        'delete',
    ];

    public $showModal = false;

    public $editModal = false;

    public array $listsForFields = [];

    protected $rules = [
        'title'         => ['required', 'string', 'max:255'],
        'description'   => ['nullable', 'string'],
        'link'          => ['nullable', 'string'],
        'product_id'    => ['nullable', 'integer'],
        'language_id'   => ['nullable', 'integer'],
        'embeded_video' => ['nullable'],
    ];

    public function mount(): void
    {
        $this->initListsForFields();
    }

    public function render(): View|Factory
    {
        $query = FeaturedBanner::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $featuredbanners = $query->paginate($this->perPage);

        return view('livewire.admin.featured-banner.index', ['featuredbanners' => $featuredbanners]);
    }

    public function setFeatured($id): void
    {
        FeaturedBanner::where('featured', '=', true)->update(['featured' => false]);
        $featuredbanner = FeaturedBanner::findOrFail($id);
        $featuredbanner->featured = true;
        $featuredbanner->save();

        $this->alert('success', __('Featuredbanner featured successfully!'));
    }

    #[On('editModal')]
    public function editModal(FeaturedBanner $featuredbanner): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->featuredbanner = $featuredbanner;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();
        // if product selected Helpers::productLink($product)

        if ($this->image) {
            $imageName = Str::slug($this->featuredbanner->title).'-'.Str::random(3).'.'.$this->image->extension();
            $this->image->storeAs('featuredbanners', $imageName);
            $this->featuredbanner->image = $imageName;
        }

        $this->featuredbanner->update(
            $this->all(),
        );

        $this->alert('success', __('FeaturedBanner updated successfully.'));

        $this->editModal = false;
    }

    public function showModal(FeaturedBanner $featuredbanner): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->featuredbanner = $featuredbanner;

        $this->showModal = true;
    }

    public function delete(FeaturedBanner $featuredbanner): void
    {
        $featuredbanner->delete();

        $this->alert('success', __('FeaturedBanner deleted successfully.'));
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['products'] = Product::pluck('name', 'id')->toArray();
    }
}

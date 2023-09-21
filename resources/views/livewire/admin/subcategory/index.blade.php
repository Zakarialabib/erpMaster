<div>
    @section('title', __('Subcategories'))
    <x-theme.breadcrumb :title="__('Subcategories List')" :parent="route('admin.product-subcategories.index')" :parentName="__('Subcategories List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.subcategory.create', 'createModal')">
            {{ __('Create Subcategory') }}
        </x-button>

    </x-theme.breadcrumb>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap gap-6 w-full">
            <select wire:model.live="perPage"
                class="w-auto shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="deleteSelected" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
            @endif
            @if ($this->selectedCount)
                <p class="text-sm  my-auto">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full ">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input type="checkbox" wire:model="selectPage" />
            </x-table.th>
            <x-table.th>
                {{ __('Image') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['name'] ?? null" :field="'name'" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th>
                {{ __('Category') }}
            </x-table.th>

            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($subcategories as $subcategory)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $subcategory->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $subcategory->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        <img src="{{ asset('images/subcategories/' . $subcategory->image) }}"
                            alt="{{ $subcategory->name }}" class="w-10 h-10 rounded-full object-cover">
                    </x-table.td>
                    <x-table.td>
                        {{ $subcategory->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $subcategory->category?->name }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button primary type="button"
                                wire:click="$dispatch('editModal',{ id :  {{ $subcategory->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="deleteModal({{ $subcategory->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash-alt"></i>
                            </x-button>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10" class="text-center">
                        {{ __('No entries found.') }}
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="card-body">
        <div class="pt-3">
            {{ $subcategories->links() }}
        </div>
    </div>

    <!-- Edit Modal -->

    <livewire:admin.subcategory.edit :subcategory="$subcategory" lazy />

    <!-- End Edit Modal -->

    <livewire:admin.subcategory.create lazy />
</div>

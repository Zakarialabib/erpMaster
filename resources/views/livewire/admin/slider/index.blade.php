<div>
    @section('title', __('Slider'))
    <x-theme.breadcrumb :title="__('Slider List')" :parent="route('admin.sliders.index')" :parentName="__('Slider List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.slider.create', 'createModal')">
            {{ __('Create Slider') }}
        </x-button>
    </x-theme.breadcrumb>

    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-col ">
            <div class="my-2 ">
                <select wire:model.live="perPage" name="perPage"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                    @foreach ($paginationOptions as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>

                @if ($this->selectedCount)
                    <p class="text-sm leading-5">
                        <span class="font-medium">
                            {{ $this->selectedCount }}
                        </span>
                        {{ __('Entries selected') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 ">
            <div class="my-2 ">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white text-gray-500 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th>
                {{ __('Image') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('title')" field="title" :direction="$sorts['title'] ?? null">
                {{ __('Title') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('status')" field="status" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('featured')" field="featured" :direction="$sorts['featured'] ?? null">
                {{ __('Featured') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($sliders as $slider)
                <x-table.tr>
                    <x-table.td>
                        {{-- {{ $id }} --}}
                    </x-table.td>
                    <x-table.td>
                        {{-- @if ($slider->omage)
                            <img src="{{ asset('images/sliders/' . $slider->) }}" alt="{{ $slider->title }}"
                                class="w-10 h-10 rounded-full">
                        @else
                            {{ __('No image') }}
                        @endif --}}
                    </x-table.td>
                    <x-table.td>
                        {{ $slider->title }}
                    </x-table.td>
                    <x-table.td>
                        <livewire:utils.toggle-button :model="$slider" field="status" key="{{ $slider->id }}"
                            lazy />
                    </x-table.td>
                    <x-table.td>
                        @if ($slider->featured == false)
                            <x-button success type="button" wire:click="setFeatured( {{ $slider->id }} )">
                                {{ __('Set as featured') }}
                            </x-button>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button primary type="button"
                                wire:click="$dispatch('editModal', { id:  {{ $slider->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button"
                                wire:click="$dispatch('deleteModal', { id ; {{ $slider->id }} })"
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

    <div class="px-6 py-3">
        {{ $sliders->links() }}
    </div>

    <livewire:admin.slider.edit :slider="$slider" lazy />

    <livewire:admin.slider.create lazy />
</div>

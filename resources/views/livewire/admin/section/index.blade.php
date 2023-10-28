<div>
    @section('title', __('Section List'))
    <x-theme.breadcrumb :title="__('Sections List')" :parent="route('admin.sections.index')" :parentName="__('Sections List')">

        <x-button primary href="{{ route('admin.section.settings') }}">
            {{ __('Section Settings') }}
        </x-button>

        <x-button primary type="button" wire:click="dispatchTo('admin.section.create', 'createModal')">
            {{ __('Create Section') }}
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
            @if ($this->selected)
                <x-button danger type="button" wire:click="deleteSelected" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
            @endif
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
                <p wire:click="resetSelected" wire:loading.attr="disabled"
                    class="text-sm leading-5 font-medium text-red-500 cursor-pointer ">
                    {{ __('Clear Selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full ">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>
    <div x-data="{ openMenuIndex: null }">
        <x-table>
            <x-slot name="thead">
                <x-table.th>#</x-table.th>
                <x-table.th>
                    {{ __('Page') }}
                </x-table.th>
                <x-table.th sortable wire:click="sortBy('title')" :direction="$sorts['title'] ?? null">
                    {{ __('Title') }}
                </x-table.th>
                <x-table.th sortable wire:click="sortBy('type')" :direction="$sorts['type'] ?? null">
                    {{ __('Type') }}
                </x-table.th>
                <x-table.th sortable wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">
                    {{ __('Status') }}
                </x-table.th>
                <x-table.th>
                    {{ __('Actions') }}
                </x-table.th>
            </x-slot>
            <x-table.tbody>
                @forelse($sections as $index => $section)
                    <tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $index }}">
                        <x-table.td class="flex flex-wrap gap-4">
                            <button
                                @click="openMenuIndex = (openMenuIndex === {{ $index }}) ? null : {{ $index }}">
                                <i class="fa fa-caret-down"
                                    :class="{
                                        'fa-caret-up': openMenuIndex === {{ $index }},
                                        'fa-caret-down': openMenuIndex !== {{ $index }}
                                    }"
                                    aria-hidden="true">
                                </i>
                            </button>

                            <input type="checkbox" value="{{ $section->id }}" wire:model.live="selected">
                        </x-table.td>
                        <x-table.td>
                            {{ $section->page?->title ?? '' }}
                        </x-table.td>

                        <x-table.td>
                            {{ $section->title }}
                        </x-table.td>

                        <x-table.td>
                            {{ $section->type?->label() }}
                        </x-table.td>

                        <x-table.td>
                            <livewire:utils.toggle-button :model="$section" field="status" key="{{ $section->id }}"
                                lazy />
                        </x-table.td>
                        <x-table.td>
                            <div class="flex justify-start space-x-2">
                                <x-button info type="button" wire:loading.attr="disabled"
                                    wire:click="$dispatchTo('admin.section.edit', 'editModal', { id: {{ $section->id }} })">
                                    <i class="fa fa-pen h-4 w-4"></i>
                                </x-button>
                                <x-button danger type="button"
                                    wire:click="$dispatch('deleteModal', {{ $section->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fa fa-trash h-4 w-4"></i>
                                </x-button>
                            </div>
                        </x-table.td>
                    </tr>
                    <tr x-show="openMenuIndex === {{ $index }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" x-cloak>
                        <td colspan="12">
                            <div class="text-center p-5">
                                <h1>{{ $section->title }}</h1>
                                <h1>{{ $section->subtitle }}</h1>
                                <p>{!! $section->description !!}</p>
                                <p>{{ $section->link }}</p>
                                {{-- <p>{{ $section->link }}</p> --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10" class="text-center">
                            {{ __('No entries found.') }}
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-table.tbody>
        </x-table>
    </div>
    <div class="card-body">
        <div class="pt-3">
            {{ $sections->links() }}
        </div>
    </div>

    <livewire:admin.section.edit section="{{ $section }}" lazy />

    <livewire:admin.section.create lazy />

</div>

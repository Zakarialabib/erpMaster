<div>
    @section('title', __('Adjustments list'))
    <x-theme.breadcrumb :title="__('Adjustments list')" :parent="route('admin.adjustments.index')" :parentName="__('Adjustment')">
        @can('adjustment_create')
            <x-button href="{{ route('admin.adjustments.create') }}" primary>
                {{ __('Create Adjustment') }}
            </x-button>
        @endcan
    </x-theme.breadcrumb>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model.live="perPage"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
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
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <div class="my-2">
                <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input type="checkbox" wire:model.live="selectPage" />
            </x-table.th>
            <x-table.th sortable :direction="$sorts['date'] ?? null" field="date" wire:click="sortingBy('date')">
                {{ __('Date') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['reference'] ?? null" field="reference" wire:click="sortingBy('reference')">
                {{ __('Reference') }}
            </x-table.th>
            <x-table.th>{{ __('Actions') }}</x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($adjustments as $adjustment)
                <x-table.tr wire:key="row-{{ $adjustment->id }}">
                    <x-table.td>
                        <input wire:model.live="selected" type="checkbox" />
                    </x-table.td>
                    <x-table.td>{{ $adjustment->date }}</x-table.td>
                    <x-table.td>{{ $adjustment->reference }}</x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">

                            <x-button primary type="button" wire:click="$dispatch('showModal', {{ $adjustment->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>

                            <x-button info href="{{ route('admin.adjustments.edit', $adjustment->id) }}"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>

                            <x-button danger type="button"
                                wire:click="$dispatch('deleteModal', {{ $adjustment->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </x-button>

                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="6">
                        <div class="flex justify-center">
                            {{ __('No results found') }}
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="pt-3">
        {{ $adjustments->links() }}
    </div>

    @if ($adjustment)
        @livewire('admin.adjustment.show', ['adjustment' => $adjustment])
    @endif

</div>

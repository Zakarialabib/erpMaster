<div>
    @section('title', __('Warehouses list'))
    <x-theme.breadcrumb :title="__('Warehouses list')" :parent="route('admin.warehouses.index')" :parentName="__('Warehouses list')">
        @can('warehouse_create')
            <x-button primary type="button" wire:click="$dispatchTo('admin.warehouses.create','createModal')">
                {{ __('Create Warehouse') }}
            </x-button>
        @endcan
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
                <x-button danger type="button" wire:click="deleteSelectedModal" class="ml-3">
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
                <input type="checkbox" wire:model.live="selectPage" />
            </x-table.th>
            <x-table.th>
                {{ __('Name') }}
            </x-table.th>
            <x-table.th>
                {{ __('Products Quantity') }}
            </x-table.th>
            <x-table.th>
                {{ __('Stock Value') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>

        <x-table.tbody>

            @forelse($warehouses as $warehouse)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $warehouse->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $warehouse->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $warehouse->name }} - {{ $warehouse->phone }}
                    </x-table.td>
                    <x-table.td>
                        {{ $warehouse->total_quantity }}
                    </x-table.td>
                    <x-table.td>
                        {{ format_currency($warehouse->stock_value) }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button info type="button"
                                wire:click="$dispatch('editModal',{ id : {{ $warehouse->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="deleteModal({{ $warehouse->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </x-button>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="4">
                        <div class="flex justify-center items-center">
                            <p class="text-gray-500">{{ __('No results found') }}</p>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="mt-4">
        {{ $warehouses->links() }}
    </div>

    <livewire:admin.warehouses.edit :warehouse="$warehouse" lazy />

    <livewire:admin.warehouses.create lazy />

</div>

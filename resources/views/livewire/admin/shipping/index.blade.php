<div>
    @section('title', __('Shipping'))
    <x-theme.breadcrumb :title="__('Shipping List')" :parent="route('admin.shipping.index')" :parentName="__('Shipping List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.shipping.create' , 'createModal')">
            {{ __('Create Shipping') }}
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

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input type="checkbox" wire:model="selectPage" />
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('name')" field="name" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('price')" field="price" :direction="$sorts['price'] ?? null">
                {{ __('Price') }}
            </x-table.th>
            <x-table.th>
                {{ __('Is pickup') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($shippings as $shipping)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $shipping->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $shipping->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $shipping->title }} <br>
                        <small>{{ $shipping->subtitle }}</small>
                    </x-table.td>
                    <x-table.td>
                        {{ $shipping->cost }}
                    </x-table.td>
                    <x-table.td>
                        @if ($shipping->is_pickup == true)
                            <x-badge info>{{ __('Pickup') }}</x-badge>
                        @else
                            <x-badge secondary>{{ __('Delivery') }}</x-badge>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-center">
                            <x-button primary type="button"
                                wire:click="$dispatch('editModal',{ id : {{ $shipping->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="deleteModal({{ $shipping->id }})"
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

    <div class="pt-3">

        {{ $shippings->links() }}
    </div>

    <livewire:admin.shipping.edit :shipping="$shipping" lazy />

    <livewire:admin.shipping.create lazy />
</div>

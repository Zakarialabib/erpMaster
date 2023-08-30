<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model.live="perPage"
                class="w-20 border border-gray-300 rounded-md shadow-sm py-2 px-4 bg-white text-sm leading-5 font-medium text-gray-700 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger wire:click="deleteSelected" class="ml-3">
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
                <x-input wire:model.live.debounce.500ms="search" placeholder="{{ __('Search') }}" autofocus />
            </div>
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
                            <x-button info type="button" wire:click="editModal({{ $warehouse->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="$dispatch('deleteModal', {{ $warehouse->id }})"
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


    <x-modal wire:model.live="editModal">
        <x-slot name="title">
            {{ __('Edit Warehouse') }}
        </x-slot>
        <x-slot name="content">
            <form wire:submit="update">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="lg:w-1/2 sm:full px-3 mb-6">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text"
                            wire:model.blur="warehouse.name" required />
                        <x-input-error :messages="$errors->get('warehouse.name')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 sm:full px-3 mb-6">
                        <x-label for="phone" :value="__('Phone')" />
                        <x-input id="phone" class="block mt-1 w-full" type="text"
                            wire:model.blur="warehouse.phone" />
                        <x-input-error :messages="$errors->get('warehouse.phone')" class="mt-2" />
                    </div>
                    <x-accordion title="{{ __('Details') }}">
                        <div class="flex flex-wrap">
                            <div class="lg:w-1/2 sm:full px-3 mb-6">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email"
                                    wire:model.blur="warehouse.email" />
                                <x-input-error :messages="$errors->get('warehouse.email')" class="mt-2" />
                            </div>
                            <div class="lg:w-1/2 sm:full px-3 mb-6">
                                <x-label for="city" :value="__('City')" />
                                <x-input id="city" class="block mt-1 w-full" type="text"
                                    wire:model.blur="warehouse.city" />
                                <x-input-error :messages="$errors->get('warehouse.city')" class="mt-2" />
                            </div>
                            <div class="hidden xl:w-1/2 md:w-1/2 px-3 mb-6 md:mb-0">
                                <x-label for="country" :value="__('Country')" />
                                <x-input id="country" class="block mt-1 w-full" type="text"
                                    wire:model.blur="warehouse.country" />
                                <x-input-error :messages="$errors->get('warehouse.country')" class="mt-2" />
                            </div>
                        </div>
                    </x-accordion>
                    <div class="w-full px-3">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>


    <livewire:admin.warehouses.create />

</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            window.livewire.on('deleteModal', warehouseId => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit('delete', warehouseId)
                    }
                })
            })
        })
    </script>
@endpush

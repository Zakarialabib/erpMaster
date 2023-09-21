<div>
    @section('title', __('Supplier'))
    <x-theme.breadcrumb :title="__('Supplier List')" :parent="route('admin.suppliers.index')" :parentName="__('Supplier List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.suppliers.create', 'createModal')">
            {{ __('Create Supplier') }}
        </x-button>
    </x-theme.breadcrumb>

    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model.live="perPage"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="deleteSelected" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
                <x-button success type="button" wire:click="downloadSelected" wire:loading.attr="disabled">
                    {{ __('EXCEL') }}
                </x-button>
                <x-button warning type="button" wire:click="exportSelected" wire:loading.attr="disabled">
                    {{ __('PDF') }}
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
            <x-table.th sortable :direction="$sorts['name'] ?? null" :field="'name'" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>

            <x-table.th sortable :direction="$sorts['phone'] ?? null" :field="'phone'" wire:click="sortingBy('phone')">
                {{ __('Phone') }}
            </x-table.th>

            <x-table.th sortable :direction="$sorts['address'] ?? null" :field="'address'" wire:click="sortingBy('address')">

                {{ __('Address') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($suppliers as $supplier)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $supplier->id }}">
                    <x-table.td class="pr-0">
                        <input type="checkbox" wire:model.live="selected" value="{{ $supplier->id }}" />
                    </x-table.td>
                    <x-table.td>
                        <button type="button" wire:click="showModal({{ $supplier->id }})">
                            {{ $supplier->name }}
                        </button>
                    </x-table.td>
                    <x-table.td>
                        {{ $supplier->phone }}
                    </x-table.td>
                    <x-table.td>
                        {{ $supplier->address }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-dropdown align="right" width="56">
                                <x-slot name="trigger" class="inline-flex">
                                    <x-button primary type="button" class="text-white flex items-center">
                                        <i class="fas fa-angle-double-down"></i>
                                    </x-button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link wire:click="showModal({{ $supplier->id }})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-eye"></i>
                                        {{ __('View') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('admin.supplier.details', $supplier->id) }}">
                                        <i class="fas fa-book"></i>
                                        {{ __('Details') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link wire:click="$dispatch('editModal', { id : {{ $supplier->id }} })"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-edit"></i>
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click="$dispatch('deleteModal', { id :{{ $supplier->id }} })"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-trash"></i>
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="12">
                        <div class="flex justify-center items-center space-x-2">
                            <i class="fas fa-box-open text-3xl text-gray-400"></i>
                            <span class="text-gray-400">{{ __('No suppliers found.') }}</span>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="px-6 py-3">
        {{ $suppliers->links() }}
    </div>


    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Supplier') }} {{ $supplier?->name }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap -mx-2 mb-3">
                <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                    <x-label for="name" :value="__('Name')" />
                    <p>{{ $supplier?->name }}</p>
                </div>

                <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                    <x-label for="phone" :value="__('Phone')" />
                    <p>{{ $supplier?->phone }}</p>
                </div>

                <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                    <x-label for="address" :value="__('Address')" />
                    <p>{{ $supplier?->address }}</p>
                </div>

                <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                    <x-label for="city" :value="__('City')" />
                    <p>{{ $supplier?->city }}</p>
                </div>

                <div class="md:w-1/2 sm:w-full px-3 mb-4 lg:mb-0">
                    <x-label for="tax_number" :value="__('Tax Number')" />
                    <p>{{ $supplier?->tax_number }}</p>
                </div>
            </div>
        </x-slot>
    </x-modal>


    <livewire:admin.suppliers.edit :supplier="$supplier" lazy />

    <livewire:admin.suppliers.create lazy />

    {{-- Import modal --}}
    <x-modal wire:model="importModal">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                {{ __('Import Excel') }}
                <x-button primary wire:click="downloadSample" type="button">
                    {{ __('Download Sample') }}
                </x-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit="import">
                <div class="mb-4">
                    <div class="w-full px-3 mt-4">
                        <x-label for="import" :value="__('Import')" />
                        <x-input id="import" class="block mt-1 w-full" type="file" name="import"
                            wire:model="import_file" />
                        <x-input-error :messages="$errors->get('import')" for="import" class="mt-2" />
                    </div>

                    <div class="w-full px-3">
                        <x-button primary type="submit" class="w-full text-center" wire:loading.attr="disabled">
                            {{ __('Import') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    {{-- End Import modal --}}
</div>

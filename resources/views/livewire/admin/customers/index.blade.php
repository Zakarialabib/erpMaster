<div>
    @section('title', __('Customer'))

    <x-theme.breadcrumb :title="__('Customer List')" :parent="route('admin.customers.index')" :parentName="__('Customer List')">
        <x-button primary type="button" wire:click="$set('importModal', true)">
            {{ __('Import Customer') }}
        </x-button>
        <x-button primary type="button" wire:click="dispatch('createModal')">
            {{ __('Create Customer') }}
        </x-button>
    </x-theme.breadcrumb>

    <div class="flex flex-wrap justify-center">
        <div class="md:w-1/2 sm:w-full flex flex-wrap my-2 space-x-2">
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
                <p wire:click="resetSelected" wire:loading.attr="disabled"
                    class="text-sm leading-5 font-medium text-red-500 cursor-pointer ">
                    {{ __('Clear Selected') }}
                </p>
            @endif

        </div>
        <div class="md:w-1/2 sm:w-full my-2">
            <div class="my-2">
                <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input wire:model.live="selectPage" type="checkbox" />
            </x-table.th>
            <x-table.th sortable :direction="$sorts['name'] ?? null" field="name" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['phone'] ?? null" field="phone" wire:click="sortingBy('phone')">
                {{ __('Phone') }}
            </x-table.th>
            <x-table.th>
                {{ __('Address') }}
            </x-table.th>
            <x-table.th>
                {{ __('Tax number') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($customers as $customer)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $customer->id }}">
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $customer->id }}" wire:model.live="selected" />
                    </x-table.td>
                    <x-table.td>
                        <button type="button" wire:click="$dispatch('showModal', { id : '{{ $customer->id }}' })"
                            class="text-indigo-500 hover:text-indigo-600">
                            {{ $customer->name }}
                        </button>
                    </x-table.td>
                    <x-table.td>
                        <a href="tel:{{ $customer->phone }}" target="__blank" class="text-blue-500 hover:underline">
                            {{ $customer->phone }}
                        </a>
                    </x-table.td>
                    <x-table.td>
                        {{ $customer->address }}
                    </x-table.td>
                    <x-table.td>
                        {{ $customer->tax_number }}
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
                                    <x-dropdown-link
                                        wire:click="$dispatch('showModal', { id : '{{ $customer->id }}' })"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-eye"></i>
                                        {{ __('View') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('admin.customer.details', $customer->id) }}">
                                        <i class="fas fa-book"></i>
                                        {{ __('Details') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link wire:click="$dispatch('editModal', { id : '{{ $customer->id }}'})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-edit"></i>
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click="$dispatch('deleteModal', {{ $customer->id }})"
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
                            <span class="text-gray-400">{{ __('No customers found.') }}</span>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="pt-3">
        {{ $customers->links() }}
    </div>

    <livewire:admin.customers.show :customer="$customer" lazy />

    <livewire:admin.customers.edit :customer="$customer" lazy />

    <livewire:admin.customers.create lazy />

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
            <form wire:submit="importExcel">
                <div class="space-y-4">
                    <div class="mt-4">
                        <x-label for="file" :value="__('Import')" />
                        <x-input id="file" class="block mt-1 w-full" type="file" name="file"
                            wire:model="file" />
                        <x-input-error :messages="$errors->get('file')" for="file" class="mt-2" />
                    </div>

                    <x-table-responsive>
                        <x-table.tr>
                            <x-table.th>{{ __('Name') }}</x-table.th>
                            <x-table.td>{{ __('Required') }}</x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.th>{{ __('Phone') }}</x-table.th>
                            <x-table.td>{{ __('Required') }}</x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.th>{{ __('Email') }}</x-table.th>
                            <x-table.td>{{ __('Optional') }}</x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.th>{{ __('Address') }}</x-table.th>
                            <x-table.td>{{ __('Optional') }}</x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.th>{{ __('City') }}</x-table.th>
                            <x-table.td>{{ __('Optional') }}</x-table.td>
                        </x-table.tr>
                        <x-table.tr>
                            <x-table.th>{{ __('Tax Number') }}</x-table.th>
                            <x-table.td>{{ __('Optional') }}</x-table.td>
                        </x-table.tr>
                    </x-table-responsive>

                    <div class="w-full flex justify-start">
                        <x-button primary type="submit" wire:loading.attr="disabled">
                            {{ __('Import') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>

<div>
    @section('title', __('Currencies'))
    <x-theme.breadcrumb :title="__('Currencies List')" :parent="route('admin.currencies.index')" :parentName="__('Currencies List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.currency.create', 'createModal')">
            {{ __('Create Currency') }}
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
                <p wire:click="resetSelected" wire:loading.attr="disabled"
                    class="text-sm leading-5 font-medium text-red-500 cursor-pointer ">
                    {{ __('Clear Selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input type="checkbox" wire:model.live="selectPage" />
            </x-table.th>
            <x-table.th sortable :direction="$sorts['name'] ?? null" field="name" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['code'] ?? null" field="code" wire:click="sortingBy('code')">
                {{ __('Code') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['symbol'] ?? null" field="symbol" wire:click="sortingBy('symbol')">
                {{ __('Symbol') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['rate'] ?? null" field="rate" wire:click="sortingBy('rate')">
                {{ __('Rate') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($currencies as $currency)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $currency->id }}">
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $currency->id }}" wire:model.live="selected" />
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->code }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->symbol }}
                    </x-table.td>
                    <x-table.td>
                        {{ $currency->exchange_rate }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button alert wire:click="$dispatch('showModal', { id : '{{ $currency->id }}'})"
                                type="button" wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>

                            <x-button primary wire:click="$dispatch('editModal', { id : '{{ $currency->id }}'})"
                                type="button" wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>

                            <x-button danger wire:click="$dispatch('deleteModal', { id : '{{ $currency->id }}'})"
                                type="button" wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </x-button>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="8">
                        <div class="flex items-center justify-center">
                            <span class="dark:text-gray-300">{{ __('No results found') }}</span>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="pt-3">

        {{ $currencies->links() }}
    </div>

    <livewire:admin.currency.show :currency="$currency" />

    <livewire:admin.currency.edit :currency="$currency" />

    <livewire:admin.currency.create lazy />
</div>

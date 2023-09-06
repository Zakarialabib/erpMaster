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
            <x-table.th sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('code')" :direction="$sorts['code'] ?? null">
                {{ __('Code') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('symbol')" :direction="$sorts['symbol'] ?? null">
                {{ __('Symbol') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortBy('rate')" :direction="$sorts['rate'] ?? null">
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
                            <x-button alert wire:click="showModal({{ $currency->id }})" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>

                            <x-button primary wire:click="$dispatch('editModal', {{ $currency->id }})" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>

                            <x-button danger wire:click="$dispatch('deleteModal', {{ $currency->id }})" type="button"
                                wire:loading.attr="disabled">
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

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $currencies->links() }}
        </div>
    </div>
    
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Currency') }} {{ $currency?->name}}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col">
                <div class="flex flex-col">
                    <x-label for="currency.name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" required type="text" disabled
                        wire:model="currency.name" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.code" :value="__('Code')" />
                    <x-input id="code" class="block mt-1 w-full" type="text" disabled
                        wire:model="currency.code" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.symbol" :value="__('Symbol')" />
                    <x-input id="symbol" class="block mt-1 w-full" type="text" disabled
                        wire:model="currency.symbol" />
                </div>
                <div class="flex flex-col">
                    <x-label for="currency.rate" :value="__('Rate')" />
                    <x-input id="rate" class="block mt-1 w-full" type="text" disabled
                        wire:model="currency.rate" />
                </div>
            </div>
        </x-slot>
    </x-modal>

    
    <livewire:admin.currency.edit :currency="$currency" />

    <livewire:admin.currency.create lazy />
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            window.livewire.on('deleteModal', currencyId => {
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
                        window.livewire.emit('delete', currencyId)
                    }
                })
            })
        })
    </script>
@endpush

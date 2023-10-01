<div>
    @section('title', __('Orders'))
    <x-theme.breadcrumb :title="__('Orders list')" :parent="route('admin.orders.index')" :parentName="__('Orders list')" />

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
    <div class="grid gap-4 grid-cols-2 justify-center mb-2">
        <div class="w-full flex flex-wrap">
            <div class="w-full md:w-1/2 px-2">
                <label>{{ __('Start Date') }} <span class="text-red-500">*</span></label>
                <x-input wire:model.live="startDate" type="date" name="startDate" value="$startDate" />
                @error('startDate')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-2">
                <label>{{ __('End Date') }} <span class="text-red-500">*</span></label>
                <x-input wire:model.live="endDate" type="date" name="endDate" value="$endDate" />
                @error('endDate')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="gap-2 inline-flex items-center mx-0 px-2">
            <x-button type="button" primary wire:click="filterByType('day')">{{ __('Today') }}</x-button>
            <x-button type="button" info wire:click="filterByType('month')">{{ __('This Month') }}</x-button>
            <x-button type="button" warning wire:click="filterByType('year')">{{ __('This Year') }}</x-button>
        </div>
    </div>
    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th>
                {{ __('User') }}
            </x-table.th>
            <x-table.th>
                {{ __('Customer Infos') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Total Amount') }}
            </x-table.th>
            <x-table.th>
                {{ __('Shipping Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($orders as $order)
                <x-table.tr>
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $order->id }}" wire:model.live="selected" />
                    </x-table.td>
                    <x-table.td>
                        @if ($order->user_id != null)
                            {{ $order->user->name }}
                        @else
                            {{ __('Not assigned') }}
                        @endif
                    </x-table.td>
                    <x-table.td class="overflow-hidden text-clip whitespace-pre" style="white-space: initial">
                        @if ($order->customer_id != null)
                            {{ $order->customer->name }} -
                            {{ $order->customer->email }} -
                            {{ $order->customer->phone }}
                        @endif
                    </x-table.td>
                    <x-table.td>
                        @php
                            $badgeType = $order->status->getBadgeType();
                        @endphp
                        <x-badge :type="$badgeType">{{ $order->status->label() }}</x-badge>
                    </x-table.td>
                    <x-table.td>
                        {{ format_currency($order->total_amount) }}
                    </x-table.td>
                    <x-table.td>
                        {{ $order->shipping_status->label() }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button target="_blank" success href="{{ route('admin.order.pdf', $order->id) }}"
                                wire:loading.attr="disabled">
                                <i class="fas fa-print"></i>
                            </x-button>

                            <x-button info wire:click="$dispatch('showModal','{{ $order->id }}')" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>
                            <x-button primary wire:click="$dispatch('editModal','{{ $order->id }}')" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>

                            <x-button primary
                                wire:click="dispatchTo('admin.delivery.create', 'createModal', { item_id : '{{ $order->id }}' , type : 'order'} )"
                                type="button" wire:loading.attr="disabled">
                                <i class="fas fa-truck"></i>
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

    <div>
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $orders->links() }}
        </div>
    </div>

    <livewire:admin.order.edit :order="$order" lazy />

    <livewire:admin.order.show :order="$order" lazy />

    <livewire:admin.delivery.create lazy />
</div>

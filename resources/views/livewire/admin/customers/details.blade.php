<div>
    @section('title', __('Customer'))
    <x-theme.breadcrumb :title="__('Customer Detail')" :parent="route('admin.customers.index')" :parentName="__('Customer List')" :childrenName="__('Customer Detail')" :children="URL::Current()">
        <h2 class="mb-1 text-2xl font-bold">
            {{ __('Customer Detail') }} : {{ $customer->name }}
        </h2>
    </x-theme.breadcrumb>

    <div class="w-full">
        <div class="w-full flex flex-wrap align-center mb-4">
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 w-full">
                <div class="flex items-center p-4 bg-white dark:bg-dark-bg dark:text-gray-300 rounded-lg shadow-md">
                    <div>
                        <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Sales Total') }}
                        </p>
                        <p class="text-3xl sm:text-lg font-bold text-indigo-700 dark:text-indigo-600">
                            {{ format_currency($this->totalSales) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-white dark:bg-dark-bg dark:text-gray-300 rounded-lg shadow-md">
                    <div>
                        <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Total Payments') }}
                        </p>
                        <p class="text-3xl sm:text-lg font-bold text-indigo-700 dark:text-indigo-600">
                            {{ format_currency($this->totalPayments) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-white dark:bg-dark-bg dark:text-gray-300 rounded-lg shadow-md">
                    <div>
                        <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Total Sale Returns') }}
                        </p>
                        <p class="text-3xl sm:text-lg font-bold text-indigo-700 dark:text-indigo-600">
                            {{ format_currency($this->totalSaleReturns) }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-white dark:bg-dark-bg dark:text-gray-300 rounded-lg shadow-md">
                    <div>
                        <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Total Due') }}
                        </p>
                        <p class="text-3xl sm:text-lg font-bold text-indigo-700 dark:text-indigo-600">
                            {{ format_currency($this->totalDue) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-white dark:bg-dark-bg dark:text-gray-300 rounded-lg shadow-md">
                    <div>
                        <p class="mb-2 text-lg font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Profit') }}
                        </p>
                        <p class="text-3xl sm:text-lg font-bold text-indigo-700 dark:text-indigo-600">
                            {{ format_currency($customer->getProfit()) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full px-2 my-5">
        <h2 class="my-5 text-2xl font-bold">
            {{ __('Sales') }}
        </h2>
        <div class="flex flex-wrap justify-center">
            <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
                <select wire:model.live="perPage" name="perPage"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
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
                @endif
            </div>
            <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
                <div class="my-2">
                    <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
                </div>
            </div>
        </div>
        <div>
            <x-table>
                <x-slot name="thead">
                    <x-table.th>
                        <input type="checkbox" wire:model.live="selectPage" />
                    </x-table.th>
                    <x-table.th sortable wire:click="sortingBy('date')" field="date" :direction="$sorts['date'] ?? null">
                        {{ __('Date') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortingBy('customer_id')" field="customer_id" :direction="$sorts['customer_id'] ?? null">
                        {{ __('Customer') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortingBy('payment_status')" field="payment_status"
                        :direction="$sorts['payment_status'] ?? null">
                        {{ __('Payment status') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortingBy('due_amount')" field="due_amount" :direction="$sorts['due_amount'] ?? null">
                        {{ __('Due Amount') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortingBy('total')" field="total" :direction="$sorts['total'] ?? null">
                        {{ __('Total') }}
                    </x-table.th>
                    <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                        {{ __('Status') }}
                    </x-table.th>
                </x-slot>

                <x-table.tbody>
                    @forelse ($this->sales as $sale)
                        <x-table.tr wire:loading.class.delay="opacity-50">
                            <x-table.td>
                                <input type="checkbox" value="{{ $sale->id }}" wire:model.live="selected" />
                            </x-table.td>
                            <x-table.td>
                                {{ $sale->date }}
                            </x-table.td>
                            <x-table.td>
                                {{ $sale->customer->name }}
                            </x-table.td>
                            <x-table.td>
                                @php
                                    $type = $sale->payment_status->getBadgeType();
                                @endphp
                                <x-badge :type="$type">{{ $sale->payment_status->label() }}</x-badge>
                            </x-table.td>
                            <x-table.td>
                                {{ format_currency($sale->due_amount) }}
                            </x-table.td>

                            <x-table.td>
                                {{ format_currency($sale->total_amount) }}
                            </x-table.td>

                            <x-table.td>
                                @php
                                    $badgeType = $sale->status->getBadgeType();
                                @endphp

                                <x-badge :type="$badgeType">{{ $sale->status->label() }}</x-badge>
                            </x-table.td>

                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="7">
                                <div class="flex justify-center items-center">
                                    <span class="text-gray-400 dark:text-gray-300">{{ __('No results found') }}</span>
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table>
        </div>

        <div class="px-6 py-3">
            {{ $this->sales->links() }}
        </div>

    </div>
    <div class="w-full px-2 mb-5">

        <h2 class="my-5 text-2xl font-bold">
            {{ __('Payments') }}
        </h2>
        <x-table>
            <x-slot name="thead">
                <x-table.th>{{ __('Date') }}</x-table.th>
                <x-table.th>{{ __('Reference') }}</x-table.th>
                <x-table.th>{{ __('Amount') }}</x-table.th>
                <x-table.th>{{ __('Payment Method') }}</x-table.th>
            </x-slot>
            <x-table.tbody>
                @foreach ($this->customerPayments as $customerPayment)
                    @forelse ($customerPayment->salepayments as $salepayment)
                        <x-table.tr>
                            <x-table.td>{{ $salepayment->created_at }}</x-table.td>
                            <x-table.td>{{ $salepayment->sale->reference }}</x-table.td>
                            <x-table.td>
                                {{ format_currency($salepayment->amount) }}
                            </x-table.td>
                            <x-table.td>{{ $salepayment->payment_method }}</x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="3">{{ __('No data found') }}</x-table.td>
                        </x-table.tr>
                    @endforelse
                @endforeach
            </x-table.tbody>
        </x-table>

        <div class="mt-4">
            {{ $this->customerPayments->links() }}
        </div>
    </div>
</div>

<div>
    @section('title', __('Customers Report'))

    <x-theme.breadcrumb :title="__('Customers Report')" :parent="route('admin.customers-report.index')" :parentName="__('Customers Report')" />


    <div class="w-full p-4">
        <form wire:submit="generateReport">
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4">
                <div>
                    <label>{{ __('Start Date') }} <span class="text-red-500">*</span></label>
                    <x-input wire:model="start_date" type="date" name="start_date" />
                    @error('start_date')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>{{ __('End Date') }} <span class="text-red-500">*</span></label>
                    <x-input wire:model="end_date" type="date" name="end_date" />
                    @error('end_date')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>{{ __('Customer') }}</label>
                    <x-select-list :options="$customers" name="customer_id" id="customer_id"
                        wire:model.live="customer_id" />
                </div>
                <div>
                    <label>{{ __('Payment Status') }}</label>
                    <select wire:model="payment_status"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        name="payment_status" id="payment_status" required>
                        @foreach (\App\Enums\PaymentStatus::cases() as $status)
                            <option value="{{ $status->value }}">
                                {{ __($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="my-4 text-center">
                <x-button type="submit" primary wire:target="generateReport" wire:loading.attr="disabled">
                    {{ __('Filter Report') }}
                </x-button>
            </div>
        </form>
    </div>

    <div class="p-4">
        <x-table>
            <x-slot name="thead">
                <x-table.th>{{ __('Date') }}</x-table.th>
                <x-table.th>{{ __('Reference') }}</x-table.th>
                <x-table.th>{{ __('Customer') }}</x-table.th>
                <x-table.th>{{ __('Status') }}</x-table.th>
                <x-table.th>{{ __('Total') }}</x-table.th>
                <x-table.th>{{ __('Paid') }}</x-table.th>
                <x-table.th>{{ __('Due') }}</x-table.th>
                <x-table.th>{{ __('Payment Status') }}</x-table.th>
            </x-slot>
            <x-table.tbody>
                @forelse($this->sales as $sale)
                    <x-table.tr>
                        <x-table.td>{{ format_date($sale->date) }}</x-table.td>
                        <x-table.td>{{ $sale->reference }}</x-table.td>
                        <x-table.td>
                            <a href="{{ route('admin.customer.details', $sale->customer?->id) }}"
                                class="text-indigo-500 hover:text-indigo-600">
                                {{ $sale->customer->name }}
                            </a>
                        </x-table.td>
                        <x-table.td>
                            @php
                                $badgeType = $sale->status->getBadgeType();
                            @endphp

                            <x-badge :type="$badgeType">{{ $sale->status->label() }}</x-badge>
                        </x-table.td>
                        <x-table.td>{{ format_currency($sale->total_amount) }}</x-table.td>
                        <x-table.td>{{ format_currency($sale->paid_amount) }}</x-table.td>
                        <x-table.td>{{ format_currency($sale->due_amount) }}</x-table.td>
                        <x-table.td>
                            @php
                                $type = $sale->payment_status->getBadgeType();
                            @endphp
                            <x-badge :type="$type">{{ $sale->payment_status->label() }}</x-badge>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="8">
                            <p class="text-center text-red-500">{{ __('No Sales Data Available!') }}</p>
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-table.tbody>
        </x-table>
        <div @class(['mt-3' => $this->sales->hasPages()])>
            {{ $this->sales->links() }}
        </div>
    </div>

</div>

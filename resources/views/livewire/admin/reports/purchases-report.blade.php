<div>
    @section('title', __('Purchase Report'))

    <x-theme.breadcrumb :title="__('Purchase Report')" :parent="route('admin.purchases-report.index')" :parentName="__('Purchase Report')" />

    <div class="w-full px-4">
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

                    <label>{{ __('Supplier') }}</label>
                    <select wire:model="supplier_id"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        name="supplier_id">
                        <option value="">{{ __('Select Supplier') }}</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                    <label>{{ __('Status') }}</label>
                    <select wire:model="purchase_status"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        name="purchase_status">
                        @foreach (\App\Enums\PurchaseStatus::cases() as $status)
                            <option value="{{ $status->value }}">
                                {{ __($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="xl:w-1/3 lg:w-1/2 sm:w-full px-3">
                    <label>{{ __('Payment Status') }}</label>
                    <select wire:model="payment_status"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        name="payment_status">
                        <option value="">{{ __('Select Payment Status') }}</option>
                        @foreach (\App\Enums\PaymentStatus::cases() as $status)
                            <option value="{{ $status->value }}">
                                {{ __($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4 md:mb-0">
                <x-button type="submit" wire:target="generateReport" wire:loading.attr="disabled">
                    {{ __('Filter Report') }}
                </x-button>
            </div>
        </form>
    </div>

    <div class="flex flex-row pt-3">
        <div class="w-full">
            <x-table>
                <x-slot name="thead">
                    <x-table.th>{{ __('Date') }}</x-table.th>
                    <x-table.th>{{ __('Reference') }}</x-table.th>
                    <x-table.th>{{ __('Supplier') }}</x-table.th>
                    <x-table.th>{{ __('Status') }}</x-table.th>
                    <x-table.th>{{ __('Total') }}</x-table.th>
                    <x-table.th>{{ __('Paid') }}</x-table.th>
                    <x-table.th>{{ __('Due') }}</x-table.th>
                    <x-table.th>{{ __('Payment Status') }}</x-table.th>
                </x-slot>
                <x-table.tbody>
                    @forelse($purchases as $purchase)
                        <x-table.tr>
                            <x-table.td>{{ format_date($purchase->date) }}
                            </x-table.td>
                            <x-table.td>{{ $purchase->reference }}</x-table.td>
                            <x-table.td>
                                <a href="{{ route('admin.supplier.details', $purchase->supplier->id) }}"
                                    class="text-indigo-500 hover:text-indigo-600 
                                    font-bold tracking-wide">
                                    {{ $purchase->supplier->name }}
                                </a>
                            </x-table.td>
                            <x-table.td>
                                @php
                                    $badgeType = $purchase->status->getBadgeType();
                                @endphp

                                <x-badge :type="$badgeType">{{ $purchase->status->label() }}</x-badge>

                            </x-table.td>
                            <x-table.td>{{ format_currency($purchase->total_amount) }}</x-table.td>
                            <x-table.td>{{ format_currency($purchase->paid_amount) }}</x-table.td>
                            <x-table.td>{{ format_currency($purchase->due_amount) }}</x-table.td>
                            <x-table.td>
                                @php
                                    $type = $purchase->payment_status->getBadgeType();
                                @endphp
                                <x-badge :type="$type">{{ $purchase->payment_status->label() }}</x-badge>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="8">
                                <span class="text-red-500">{{ __('No Purchases Data Available') }}!</span>
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table>

            <div @class(['mt-3' => $purchases->hasPages()])>
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>

<div>
    @section('title', __('Purhcases Return Report'))

    <x-theme.breadcrumb :title="__('Purhcases Return Report')" :parent="route('admin.purchases-return-report.index')" :parentName="__('Purhcases Return Report')" />

    <div class="p-4">
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
                <div>
                    <label>{{ __('Status') }}</label>
                    <select wire:model="purchase_return_status"
                        class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                        name="purchase_return_status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach (\App\Enums\PurchaseReturnStatus::cases() as $status)
                            <option value="{{ $status->value }}">
                                {{ __($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
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
                <div class="">
                    <x-button type="submit" primary wire:target="generateReport" wire:loading.attr="disabled">
                        {{ __('Filter Report') }}
                    </x-button>
                </div>
            </div>
        </form>
    </div>

    <div class="flex flex-row">
        <div class="w-full">
            <div class="card border-0 shadow-sm">
                <div class="p-4">
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
                            @forelse($purchase_returns as $purchase_return)
                                <x-table.tr>
                                    <x-table.td>{{ format_date($purchase_return->date) }}
                                    </x-table.td>
                                    <x-table.td>{{ $purchase_return->reference }}</x-table.td>
                                    <x-table.td>
                                        <a href="{{ route('admin.supplier.details', $purchase_return->supplier->id) }}"
                                            class="text-indigo-500 hover:text-indigo-600 
                                            font-bold tracking-wide">
                                            {{ $purchase_return->supplier->name }}
                                        </a>
                                    </x-table.td>
                                    <x-table.td>
                                        @php
                                            $type = $purchase_return->status->getBadgeType();
                                        @endphp
                                        <x-badge :type="$type">{{ $purchase_return->status->label() }}</x-badge>
                                    </x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->total_amount) }}</x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->paid_amount) }}</x-table.td>
                                    <x-table.td>{{ format_currency($purchase_return->due_amount) }}</x-table.td>
                                    <x-table.td>
                                        @php
                                            $type = $purchase_return->payment_status->getBadgeType();
                                        @endphp
                                        <x-badge
                                            :type="$type">{{ $purchase_return->payment_status->label() }}</x-badge>
                                    </x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.tr>
                                    <x-table.td colspan="8">
                                        <p class="text-red-500 text-center">
                                            {{ __('No Purchase Return Data Available!') }}
                                        </p>
                                    </x-table.td>
                                </x-table.tr>
                            @endforelse
                        </x-table.tbody>
                    </x-table>
                    <div @class(['mt-3' => $purchase_returns->hasPages()])>
                        {{ $purchase_returns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

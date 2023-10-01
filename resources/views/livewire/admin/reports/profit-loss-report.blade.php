<div>
    @section('title', __('Profit & Loss Report'))

    <x-theme.breadcrumb :title="__('Profit & Loss Report')" :parent="route('admin.profit-loss-report.index')" :parentName="__('Profit & Loss Report')" />

    <div class="w-full px-4">
        <form wire:submit="generateReport">
            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4">
                <div>
                    <x-label for="start_date" :value="__('Start Date')" required />
                    <x-input wire:model="start_date" type="date" name="start_date" />
                    @error('start_date')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror

                </div>
                <div>
                    <x-label for="end_date" :value="__('End Date')" required />
                    <x-input wire:model="end_date" type="date" name="end_date" />
                    @error('end_date')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="my-4 text-center">
                <x-button primary type="submit" wire:target="generateReport" wire:loading.attr="disabled">
                    {{ __('Filter Report') }}
                </x-button>
            </div>
        </form>
    </div>


    <div class="grid xl:grid-cols-3 sm:grid-cols-2 gap-2">
        {{-- Sales --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-receipt font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($sales_amount) }}</div>
                    <div class="uppercase font-bold text-xs ">{{ $total_sales }} {{ __('Sales') }}
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Sale Returns --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-arrow-left font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($sale_returns_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ $total_sale_returns }}
                        {{ __('Sale Returns') }}</div>
                </div>
            </div>
        </x-card>

        {{-- Profit --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="bi bi-trophy font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($profit_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ __('Profit') }}</div>
                </div>
            </div>
        </x-card>

        {{-- Purchases --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="bi bi-bag font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($purchases_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ $total_purchases }}
                        {{ __('Purchases') }}
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Purchase Returns --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-arrow-right font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($purchase_returns_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ $total_purchase_returns }}
                        {{ __('Purchase Returns') }}
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Expenses --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-wallet font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($expenses_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ __('Expenses') }}</div>
                </div>
            </div>
        </x-card>

        {{-- Payments Received --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-cash-register font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($payments_received_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ __('Payments Received') }}</div>
                </div>
            </div>
        </x-card>

        {{-- Payments Sent --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-money-bill font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($payments_sent_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ __('Payments Sent') }}</div>
                </div>
            </div>
        </x-card>

        {{-- Payments Net --}}
        <x-card>
            <div class="flex p-2 items-center gap-4">
                <div class="bg-blue-600 text-white p-5 rounded">
                    <i class="fa fa-money-bills font-2xl"></i>
                </div>
                <div>
                    <div class="text-bold">{{ format_currency($payments_net_amount) }}</div>
                    <div class="text-uppercase font-bold text-sm">{{ __('Payments Net') }}</div>
                </div>
            </div>
        </x-card>
    </div>
</div>

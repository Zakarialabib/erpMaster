<div>
    <div class="flex flex-wrap py-3">

        <div class="mb-6 px-4 flex justify-center gap-4 items-center w-full">
            <label class="font-semibold">{{ __('from') }}:</label>
            <div class="flex-1">
                <input type="date" wire:model.live="startDate" class="w-full border rounded px-2 py-1">
            </div>
            <span class="mx-2 font-semibold">{{ __('to') }}</span>
            <div class="flex-1">
                <input type="date" wire:model.live="endDate" class="w-full border rounded px-2 py-1">
            </div>
        </div>

        @can('show total stats')
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="blue" counter="{{ $categoriesCount }}" title="{{ __('Total Categories') }}"
                    href="{{ route('admin.product-categories.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="orange" counter="{{ $productCount }}" title="{{ __('Total Products') }}"
                    href="{{ route('admin.products.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="green" counter="{{ $supplierCount }}" title="{{ __('Total Supplier') }}"
                    href="{{ route('admin.suppliers.index') }}">
                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="indigo" counter="{{ $customerCount }}" title="{{ __('Total Customer') }}"
                    href="{{ route('admin.customers.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="indigo" counter="{{ $subscribersCount }}" :title="__('Subscribers')"
                    href="{{ route('admin.subscribers.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="indigo" counter="{{ $ordersCount }}" :title="__('Orders')"
                    href="{{ route('admin.orders.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="indigo" counter="{{ $contactsCount }}" :title="__('Contacts')"
                    href="{{ route('admin.contacts.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="indigo" counter="{{ $orderFormProduct }}" :title="__('Order Form Products')"
                    href="{{ route('admin.orderforms') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="teal" counter="{{ $salesCount }}" :title="__('Sales')"
                    href="{{ route('admin.sales.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>
            <div class="sm:w-1/4 w-1/2 px-2 pb-2">
                <x-counter-card color="cyan" counter="{{ $purchasesCount }}" :title="__('Purchases')"
                    href="{{ route('admin.purchases.index') }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </x-counter-card>
            </div>

            {{-- Best Selling Product --}}
            {{-- <x-card-tooltip icon="bi bi-star" color="yellow">
                <span class="text-2xl">{{ $best_selling_product }}</span>
                <p>{{ __('Best Selling Product') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('The product with the highest sales quantity.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}

            {{-- Number of Products Sold --}}
            {{-- <x-card-tooltip icon="bi bi-box" color="purple">
                <span class="text-2xl">{{ $number_of_products_sold }}</span>
                <p>{{ __('Number of Products Sold') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('Total number of products sold during the selected period.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}

            {{-- Average Purchase Return Amount --}}
            {{-- <x-card-tooltip icon="fa fa-arrow-left" color="red">
                <span class="text-2xl">{{ format_currency($average_purchase_return_amount) }}</span>
                <p>{{ __('Average Purchase Return Amount') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('Average amount refunded for purchase returns.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}

            {{-- Common Return Reason --}}
            {{-- <x-card-tooltip icon="fa fa-exclamation-triangle" color="orange">
                <span class="text-2xl">{{ $common_return_reason }}</span>
                <p>{{ __('Common Return Reason') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('The most common reason for purchase returns.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}

            {{-- Average Payment Received per Sale --}}
            {{-- <x-card-tooltip icon="fa fa-dollar-sign" color="green">
                <span class="text-2xl">{{ format_currency($average_payment_received_per_sale) }}</span>
                <p>{{ __('Average Payment Received per Sale') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('Average amount received for each completed sale.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}

            {{-- Significant Payment Changes --}}
            {{-- <x-card-tooltip icon="fa fa-chart-line" color="blue">
                <span class="text-2xl">{{ $significant_payment_changes }}</span>
                <p>{{ __('Significant Payment Changes') }}</p>
                <x-slot name="content">
                    <p class="text-sm">
                        {{ __('Detects any significant changes in payment patterns.') }}
                    </p>
                </x-slot>
            </x-card-tooltip> --}}
        @endcan
    </div>
    <div class="flex flex-wrap">
        <div class="lg:w-1/2 sm:w-full pb-2 mb-2 bg-white relative">
            <div class="flex w-full px-4 justify-between items-center">
                <h3>{{ __('Sales/Purchases') }}</h3>
            </div>
            <div id="chart"></div>
        </div>
        <div class="lg:w-1/2 sm:w-full pb-2 mb-2 bg-white relative">
            <div class="w-full px-4 justify-between items-center">
                <h3>{{ __('Monthly Cash Flow (Payment Sent & Received)') }}</h3>
            </div>
            <div id="monthly-chart"></div>
        </div>
        <div class="w-full pb-2 mb-2 bg-white relative">
            <div class="w-full px-4 justify-between items-center">
                <h3>{{ __('Daily Sales and Purchases') }}</h3>
            </div>
            <div id="daily-chart"></div>
        </div>
        <div class="w-full pb-2 mb-2 bg-white relative">
            <div class="w-full px-4 justify-between items-center">
                <h3>{{ __('Payment Chart') }}</h3>
            </div>
            <div id="payment-chart"></div>
        </div>
    </div>
    <div class="w-full px-2 pb-2 mt-2">
        <div class="bg-white rounded-lg border border-gray-200 pb-2">
            <div class="py-3 px-5 mb-3 w-full inline-flex itees-center justify-between">
                <span class="text-md font-semibold text-gray-700">{{ __('Recent Sale') }}</span>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left px-4">{{ 'Customer' }}</th>
                        <th class="text-left px-4">{{ 'Total' }}</th>
                        <th class="text-left px-4">{{ 'Date' }}</th>
                        <th class="text-left px-4">{{ 'Status' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lastSales as $sale)
                        <tr class="text-sm antialiased">
                            <td class="px-4 py-2">
                                <p class="font-bold tracking-wide text-gray-800">{{ $sale->customer?->name }}
                                </p>
                                <span class="text-indigo-600 text-xs font-semibold">{{ $sale->reference }}</span>
                            </td>
                            <td class="px-4 py-2">{{ format_currency($sale->total_amount) }}</td>
                            <td class="px-4 py-2">{{ $sale->date }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $type = $sale->status->getBadgeType();
                                @endphp
                                <x-badge :type="$type">{{ $sale->status->label() }}</x-badge>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-2 w-full pb-2">
        <div class="bg-white rounded-lg border border-gray-200 pb-2">
            <div class="py-3 px-5 mb-3 w-full inline-flex items-center justify-between">
                <span class="text-md font-semibold text-gray-700">{{ __('Recent Purchase') }}</span>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left px-4">{{ 'Supplier' }}</th>
                        <th class="text-left px-4">{{ 'Total' }}</th>
                        <th class="text-left px-4">{{ 'Date' }}</th>
                        <th class="text-left px-4">{{ 'Status' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lastPurchases as $purchase)
                        <tr class="text-sm antialiased">
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.supplier.details', $purchase->supplier->id) }}"
                                    class="text-indigo-500 hover:text-indigo-600 
                                    font-bold tracking-wide">
                                    {{ $purchase->supplier->name }}
                                </a>
                                <span class="text-indigo-600 text-xs font-semibold">{{ $purchase->reference }}</span>
                            </td>
                            <td class="px-4 py-2">{{ format_currency($purchase->total_amount) }}</td>
                            <td class="px-4 py-2">{{ $purchase->date }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $badgeType = $purchase->status->getBadgeType();
                                @endphp

                                <x-badge :type="$badgeType">{{ $purchase->status->label() }}</x-badge>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-wrap gap-y-4">
        <div class="sm:w-1/2 w-full px-2">
            <div class="bg-white rounded-lg border border-gray-200 pb-2">
                <div class="py-3 px-5 w-full inline-flex items-center justify-between text-gray-700">
                    <span class="text-md font-semibold">{{ __('Top 5 Sellers in') }} {{ now()->format('F') }}</span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Seller') }}</th>
                            <th>{{ __('Profit') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Sale Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bestSales as $sale)
                            <tr class="antialiased" wire:key="{{ $sale->id }}">
                                <td class="py-1 px-2">{{ $sale->user->name }}</td>
                                <td class="py-1 px-2">{{ format_currency($sale->total_amount) }}</td>
                                <td class="py-1 px-2">{{ $sale->customer->name }}</td>
                                <td class="py-1 px-2">{{ $sale->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="sm:w-1/2 w-full px-2">
            <div class="bg-white rounded-lg border border-gray-200 pb-2">
                <div class="py-3 px-5 w-full inline-flex items-center justify-between text-gray-700">
                    <span class="text-md font-semibold">{{ __('Top Products in') }} {{ now()->format('F') }}</span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Total Quantity') }}</th>
                            <th>{{ __('Total Sales') }}</th>
                            <th>{{ __('Warehouse') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->topProducts as $product)
                            <tr class="antialiased" wire:key="{{ $product->id }}">
                                <td class="py-1 px-2">{{ $product->name }}</td>
                                <td class="py-1 px-2">{{ $product->code }}</td>
                                <td class="py-1 px-2">{{ $product->qtyItem }}</td>
                                <td class="py-1 px-2">{{ format_currency($product->totalSalesAmount) }}</td>
                                <td class="py-1 px-2">
                                    <x-badge danger
                                        class="text-sm">{{ \App\Helpers::warehouseName($product->warehouse_id) }}</x-badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="sm:w-1/2 w-full px-2">
            <div class="bg-white rounded-lg border border-gray-200 pb-2">
                <div class="py-3 px-5 w-full inline-flex items-center justify-between text-gray-700">
                    <span class="text-md font-semibold">{{ __('Top Customers by Warehouse') }}</span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>{{ __('Warehouse') }}</th>
                            <th>{{ __('Top Customer') }}</th>
                            <th>{{ __('Total Sales') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->topCustomers as $index => $customer)
                            <tr class="antialiased" wire:key="{{ $index }}">
                                <td>{{ $index }}</td>
                                <td class="py-1 px-2">
                                    <x-badge danger
                                        class="text-sm">{{ \App\Helpers::warehouseName($customer->warehouse_id) }}</x-badge>
                                </td>

                                <td class="py-1 px-2">{{ $customer->name }}</td>

                                <td class="py-1 px-2">{{ format_currency($customer->totalSalesAmount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="sm:w-1/2 w-full px-2">
            <div class="bg-white rounded-lg border border-gray-200 pb-2">
                <div class="py-3 px-5 w-full inline-flex items-center justify-between text-gray-700">
                    <span class="text-md font-semibold">{{ __('Recent Ecommerce Orders') }}</span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Ref') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Date') }}</th>
                        </tr>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr class="text-sm antialiased" wire:key="{{ $order->id }}">

                                <td class="px-4 py-2">
                                    {{-- <a href="{{ route('admin.order.show', $order->id) }}"> --}}
                                    {{ $order->reference }}
                                    {{-- </a> --}}
                                </td>
                                <td class="px-4 py-2">{{ format_currency($order->total_amount) }}</td>
                                <td class="px-4 py-2">{{ format_date($order->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @script
        <script>
            document.addEventListener('livewire:init', () => {
                var dailyChart = new ApexCharts(document.querySelector("#daily-chart"), @json($this->dailyChartOptions));
                console.log(dailyChart);
                dailyChart.render();

                // Render the monthly cash flow chart
                var monthlyChart = new ApexCharts(document.querySelector("#monthly-chart"),
                    @json($this->monthlyChartOptions));

                monthlyChart.render();

                var paymentChart = new ApexCharts(document.querySelector("#payment-chart"),
                    @json($this->paymentChart));
                paymentChart.render();

                function chart(data, selector) {
                    let tes = data;
                    let options = {
                        series: [{
                                name: "Sales Total Amount",
                                data: tes.total.sales
                            },
                            {
                                name: "Sales Due Amount",
                                data: tes.due_amount.sales
                            },
                            {
                                name: "Purchase Total Amount",
                                data: tes.total.purchase
                            },
                            {
                                name: "Purchase Due Amount",
                                data: tes.due_amount.purchase
                            }
                        ],
                        chart: {
                            height: 350,
                            width: '100%',
                            type: "bar",
                            zoom: {
                                enabled: false
                            }
                        },
                        responsive: [{
                            breakpoint: undefined,
                            options: {},
                        }],
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                borderRadius: 4,
                                dataLabels: {
                                    position: "top"
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            offsetY: -20,
                            style: {
                                fontSize: "12px",
                                colors: ["#fff"],
                            },
                            formatter: function(val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                            },
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ["#fff"]
                        },
                        markers: {
                            size: 5,
                            colors: ["#1a56db"],
                            strokeColor: "#ffffff",
                            strokeWidth: 3
                        },
                        xaxis: {
                            categories: tes.labels,
                            labels: {
                                style: {
                                    colors: "#1a56db"
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: "Amount",
                            },
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "$" + val;
                                },
                            },
                        },
                        legend: {
                            position: "top",
                            horizontalAlign: "center",
                            offsetX: 40,
                        },
                    };
                    const chart = new ApexCharts(document.querySelector(selector), options);
                    chart.render();
                }
                chart({!! $charts !!}, '#chart');
            })
        </script>
    @endscript

</div>

<div>
    @section('title', __('Sales'))

    <x-theme.breadcrumb :title="__('Sales List')" :parent="route('admin.sales.index')" :parentName="__('Sales List')">

        <x-dropdown align="right" width="48" class="w-auto mr-2">
            <x-slot name="trigger" class="inline-flex">
                <x-button secondary type="button" class="text-white flex items-center">
                    <i class="fas fa-angle-double-down w-4 h-4"></i>
                </x-button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link wire:click="dispatch('exportAll')" wire:loading.attr="disabled">
                    {{ __('PDF') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="dispatch('downloadAll')" wire:loading.attr="disabled">
                    {{ __('Excel') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
        @can('sale_create')
            <x-button primary href="{{ route('admin.sale.create') }}">{{ __('Create Invoice') }}</x-button>
        @endcan

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
        <div class="grid gap-4 grid-cols-2 items-center justify-center">
            <div class="w-full mb-2 flex flex-wrap ">
                <div class="w-full flex-1 px-2">
                    <label>{{ __('Start Date') }} <span class="text-red-500">*</span></label>
                    <x-input wire:model.live="startDate" type="date" name="startDate" value="$startDate" />
                    @error('startDate')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full flex-1 px-2">
                    <label>{{ __('End Date') }} <span class="text-red-500">*</span></label>
                    <x-input wire:model.live="endDate" type="date" name="endDate" value="$endDate" />
                    @error('endDate')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="gap-2 inline-flex items-center mx-0 px-2 mb-2">
                <x-button type="button" primary wire:click="filterByType('day')">{{ __('Today') }}</x-button>
                <x-button type="button" info wire:click="filterByType('month')">{{ __('This Month') }}</x-button>
                <x-button type="button" warning wire:click="filterByType('year')">{{ __('This Year') }}</x-button>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input type="checkbox" wire:model.live="selectPage" />
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('reference')" field="reference" :direction="$sorts['reference'] ?? null">
                {{ __('Reference') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('date')" field="date" :direction="$sorts['date'] ?? null">
                {{ __('Date') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('customer_id')" field="customer_id" :direction="$sorts['customer_id'] ?? null">
                {{ __('Customer') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('payment_status')" field="payment_status" :direction="$sorts['payment_status'] ?? null">
                {{ __('Payment status') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('due_amount')" field="due_amount" :direction="$sorts['due_amount'] ?? null">
                {{ __('Due Amount') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('total')" field="total" :direction="$sorts['total'] ?? null">
                {{ __('Total') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('status')" field="status" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>

        <x-table.tbody>
            @forelse ($sales as $sale)
                <x-table.tr wire:loading.class.delay="opacity-50">
                    <x-table.td class="pr-0">
                        <input type="checkbox" value="{{ $sale->id }}" wire:model.live="selected" />
                    </x-table.td>
                    <x-table.td>
                        {{ $sale->reference }}
                    </x-table.td>
                    <x-table.td>
                        {{ format_date($sale->date) }}
                    </x-table.td>
                    <x-table.td>
                        @if ($sale?->customer)
                            <a class="text-blue-400 hover:text-blue-600 focus:text-blue-600"
                                href="{{ route('admin.customer.details', $sale->customer->id) }}">
                                {{ $sale?->customer?->name }}
                            </a>
                        @else
                            {{ $sale?->customer?->name }}
                        @endif

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
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-dropdown align="right" width="56">
                                <x-slot name="trigger" class="inline-flex">
                                    <x-button primary type="button" class="text-white flex items-center">
                                        <i class="fas fa-angle-double-down"></i>
                                    </x-button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link wire:click="$dispatch('showModal', { id : '{{ $sale->id }}'})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-eye"></i>
                                        {{ __('View') }}
                                    </x-dropdown-link>
                                    @if ($sale->due_amount > 0)
                                        <x-dropdown-link wire:click="sendWhatsapp({{ $sale->id }})"
                                            wire:loading.attr="disabled">
                                            <i class="fas fa-paper-plane"></i>
                                            {{ __('Send to Whatsapp') }}
                                        </x-dropdown-link>
                                    @endif
                                    @can('edit_sales')
                                        <x-dropdown-link href="{{ route('admin.sale.edit', $sale->id) }}"
                                            wire:loading.attr="disabled">
                                            <i class="fas fa-edit"></i>
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                    @endcan
                                    @can('delete_sales')
                                        <x-dropdown-link wire:click="deleteModal('{{ $sale->id }}')"
                                            wire:loading.attr="disabled">
                                            <i class="fas fa-trash"></i>
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <x-dropdown-link target="_blank"
                                        href="{{ route('admin.sales.pos.pdf', $sale->id) }}"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-print"></i>
                                        {{ __('Print Pos') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link href="{{ route('admin.sale.invoice', $sale->id) }}"
                                        target="__blank">
                                        <i class="fas fa-print"></i>
                                        {{ __('Print') }}
                                    </x-dropdown-link>

                                    @can('access_sale_payments')
                                        <x-dropdown-link
                                            wire:click="$dispatch('showPayments', {id :'{{ $sale->id }}'})" primary
                                            wire:loading.attr="disabled">
                                            <i class="fas fa-money-bill-wave"></i>
                                            {{ __('Payments') }}
                                        </x-dropdown-link>
                                    @endcan
                                    @can('access_sale_payments')
                                        @if ($sale->due_amount > 0)
                                            <x-dropdown-link
                                                wire:click="$dispatch('paymentModal',{ id : '{{ $sale->id }}'})"
                                                primary wire:loading.attr="disabled">
                                                <i class="fas fa-money-bill-wave"></i>
                                                {{ __('Add Payment') }}
                                            </x-dropdown-link>
                                        @endif
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="9">
                        <div class="flex justify-center items-center">
                            <i class="fas fa-box-open text-4xl text-gray-400"></i>
                            {{ __('No results found') }}
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="px-6 py-3">
        {{ $sales->links() }}
    </div>

    <livewire:admin.sales.show :sale="$sale" lazy />

    <livewire:admin.sales.payment-form :sale="$sale" lazy />

    @if (empty($showPayments))
        <livewire:admin.sales.payment.index :sale="$sale" />
    @endif

    @assets
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
            integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endassets
    @script
        <script>
            function printContent() {
                const content = document.getElementById("printable-content");
                html2canvas(content).then(canvas => {
                    const printWindow = window.open('', '',
                        'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
                    const printDocument = printWindow.document;
                    printDocument.body.appendChild(canvas);
                    canvas.onload = function() {
                        printWindow.print();
                        printWindow.close();
                    };
                });
            }
        </script>
    @endscript
</div>

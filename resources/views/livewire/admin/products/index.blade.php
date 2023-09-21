<div>
    @section('title', __('Product'))
    <x-theme.breadcrumb :title="__('Product List')" :parent="route('admin.products.index')" :parentName="__('Product List')">

        <x-dropdown align="right" width="48" class="w-auto mr-2">
            <x-slot name="trigger" class="inline-flex">
                <x-button secondary type="button" class="text-white flex items-center">
                    <i class="fas fa-angle-double-down w-4 h-4"></i>
                </x-button>
            </x-slot>
            <x-slot name="content">
                @can('product_import')
                    <x-dropdown-link wire:click="dispatch('importModal')" wire:loading.attr="disabled">
                        {{ __('Excel Import') }}
                    </x-dropdown-link>
                @endcan
                @can('product_export')
                    <x-dropdown-link wire:click="dispatch('exportAll')" wire:loading.attr="disabled">
                        {{ __('PDF Export') }}
                    </x-dropdown-link>
                    <x-dropdown-link wire:click="dispatch('downloadAll')" wire:loading.attr="disabled">
                        {{ __('Excel Export') }}
                    </x-dropdown-link>
                @endcan
            </x-slot>
        </x-dropdown>
        @can('product_create')
            <x-button primary type="button" wire:click="dispatchTo('admin.products.create', 'createModal')">
                {{ __('Create Product') }}
            </x-button>
        @endcan

    </x-theme.breadcrumb>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap gap-6 w-full">
            <select wire:model.live="perPage"
                class="w-auto shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($this->selected)
                <x-button danger type="button" wire:click="deleteSelectedModal" wire:loading.attr="disabled">
                    <i class="fas fa-trash"></i>
                </x-button>

                <x-button primary type="button" wire:click="promoAllProducts" wire:loading.attr="disabled">
                    <i class="fas fa-percent"></i>
                </x-button>
                <x-button success type="button" wire:click="downloadSelected" wire:loading.attr="disabled">
                    {{ __('EXCEL') }}
                </x-button>
                <x-button warning type="button" wire:click="exportSelected" wire:loading.attr="disabled">
                    {{ __('PDF') }}
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


    <x-table>
        <x-slot name="thead">
            <x-table.th>
                <input wire:model.live="selected" type="checkbox" />
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('name')" field="name" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th>
                {{ __('Total Quantity') }}
            </x-table.th>
            <x-table.th>
                {{ __('Price') }}
            </x-table.th>
            <x-table.th>
                {{ __('Cost') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('category_id')" field="category_id" :direction="$sorts['category_id'] ?? null">
                {{ __('Category') }}
            </x-table.th>
            <x-table.th>
                {{ __('Warehouse') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($products as $product)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $product->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $product->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        <button type="button" wire:click="$dispatch('showModal',{ id : {{ $product->id }}})"
                            class="whitespace-nowrap hover:text-blue-400 active:text-blue-400">
                            {{ $product->name }} <br>
                            <x-badge type="success">
                                {{ $product->code }}
                            </x-badge>
                        </button>
                    </x-table.td>
                    <x-table.td>{{ $product->total_quantity }}</x-table.td>
                    <x-table.td>{{ format_currency($product->average_price) }}</x-table.td>
                    <x-table.td>{{ format_currency($product->average_cost) }}</x-table.td>
                    <x-table.td>
                        <x-badge type="warning">
                            <a href="{{ route('admin.product-categories.index') }}"
                                class="whitespace-nowrap hover:text-blue-400 active:text-blue-400">
                                {{ $product->category->name }}
                                <small>
                                    ({{ $product->ProductsByCategory($product->category->id) }})
                                </small>
                            </a>
                        </x-badge>
                    </x-table.td>
                    <x-table.td>
                        <div class="flex flex-wrap">
                            @foreach ($product->warehouses as $warehouse)
                                <x-badge type="info">
                                        {{ $warehouse->name }}
                                        <span
                                            class="rounded-full p-1 text-xs font-semibold bg-red-500 text-white ml-2">
                                            {{ $warehouse->pivot->qty }}
                                        </span>
                                </x-badge>
                            @endforeach
                        </div>
                    </x-table.td>
                    <x-table.td>
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger" class="inline-flex">
                                <x-button primary type="button" class="text-white flex items-center">
                                    <i class="fas fa-angle-double-down"></i>
                                </x-button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link wire:click="$dispatch('highlightModal',{{ $product->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-eye"></i>
                                    {{ __('Highlighted') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="$dispatch('showModal',{ id : {{ $product->id }} })"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-eye"></i>
                                    {{ __('View') }}
                                </x-dropdown-link>
                                @if (settings('telegram_channel'))
                                    <x-dropdown-link wire:click="sendTelegram({{ $product->id }})"
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ __('Send to telegram') }}
                                    </x-dropdown-link>
                                @endif
                                <x-dropdown-link wire:click="sendWhatsapp({{ $product->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-paper-plane"></i>
                                    {{ __('Send to Whatsapp') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="$dispatch('editModal',{ id : {{ $product->id }} })"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i>
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="deleteModal({{ $product->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="8" class="text-center">
                        {{ __('No products found') }}
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
            {{ $products->links() }}
        </div>
    </div>

    <!-- Show Modal -->
    <livewire:admin.products.show :product="$product" lazy />
    <!-- End Show Modal -->

    <!-- Edit Modal -->
    <livewire:admin.products.edit :product="$product" lazy />
    <!-- End Edit Modal -->

    <livewire:admin.products.create lazy />

    {{-- Import modal --}}

    <livewire:admin.products.import lazy />

    {{-- End Import modal --}}
    <livewire:admin.products.highlighted :product="$product" lazy />

</div>

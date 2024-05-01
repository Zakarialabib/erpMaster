<div>

    <div class="card bg-white">
        <div class="py-8 bg-gray-100">
            <div class="container px-4 mx-auto">
                <div class="flex flex-wrap items-center justify-between -mx-4">
                    <div class="w-full md:w-auto px-4 mb-14 md:mb-0">
                        <h2 class="text-7xl md:text-8xl font-heading font-bold leading-relaxed">
                            {{ __('Products catalog') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-10 py-4">

            <div class="flex flex-wrap justify-center">
                <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-md-0 my-2">
                    <select wire:model="perPage"
                        class="w-20 block p-3 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                        @foreach ($paginationOptions as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
                    <div class="">
                        <input type="text" wire:model.debounce.300ms="search"
                            class="p-3 leading-5 bg-white text-gray-700 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                            placeholder="{{ __('Search') }}" />
                    </div>
                </div>
            </div>


            <x-table>
                <x-slot name="thead">
                    <x-table.th>#</x-table.th>
                    <x-table.th>
                        {{ __('Code') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">
                        {{ __('Name') }}
                        @include('components.table.sort', ['field' => 'name'])
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('stock')" :direction="$sorts['stock'] ?? null">
                        {{ __('Stock') }}
                        @include('components.table.sort', ['field' => 'stock'])
                    </x-table.th>
                    <x-table.th>
                        {{ __('Category') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Price') }} / {{ __('Wholesale Price') }}
                    </x-table.th>
                    </tr>
                </x-slot>
                <x-table.tbody>
                    @forelse($products as $product)
                        <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $product->id }}">
                            <x-table.td>
                                <input type="checkbox" value="{{ $product->id }}" wire:model="selected">
                            </x-table.td>
                            <x-table.td>
                                {{ $product->code }}
                            </x-table.td>
                            <x-table.td>
                                {{ $product->name }}
                            </x-table.td>
                            <x-table.td>

                            </x-table.td>

                            <x-table.td>
                                <p>{{ \App\Helpers::format_currency($product->price->price) }}</p>
                                @if ($product->price)
                                    <p>
                                        {{ $product->price->latestPrice()->old_price }}DH
                                    </p>
                                @endif
                                <p>
                                    {{ $product->price ? $product->price->wholesale_price : '' }}DH
                                </p>
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

        </div>
    </div>
</div>

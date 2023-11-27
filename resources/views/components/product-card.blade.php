@props(['product'])
<div itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
    <div itemprop="brand" content="{{ $product->brand }}"></div>
    <div itemprop="sku" content="{{ $product->code }}"></div>
    <div itemprop="description" content="{{ $product->description }}"></div>

    <div
        class="group relative flex flex-col overflow-hidden rounded-lg border border-red-200 bg-white hover:border-sky-300 hover:shadow-lg hover:shadow-sky-300/50 transition duration-150">
        <a href="{{ route('front.product', $product->slug) }}"
            class="flex mx-auto mb-4 w-full h-[220px] lg:h-[300px] rounded-t-lg">
            <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg group-hover:opacity-75">
                <img alt="Xiaomi 11T" class="h-full w-full object-cover object-center"
                    src="{{ asset('images/products/' . $product->image) }}">
            </div>
            <meta itemprop="image" content="{{ asset('images/products/' . $product->image) }}" />
        </a>

        @if ($product->warehouses->first()->pivot->discount_price && $product->warehouses->first()->pivot->discount != 0)
            <div class="absolute top-0 right-0 mb-3 p-2 bg-red-500 rounded-bl-lg">
                <span class="text-white font-bold text-sm">
                    - {{ $product->warehouses->first()->pivot->discount }}%
                </span>
            </div>
        @endif
        @if ($product->category)
            <div
                class="absolute top-3 md:top-5 3xl:top-7 left-3 rtl:right-3 ltr:md:left-5 rtl:md:right-5 3xl:left-7 rtl:3xl:right-7 flex flex-col gap-y-1 items-start">
                <span
                    class="bg-transparent border border-indigo-500 text-indigo-500 hover:bg-indigo-500 hover:text-white active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 md:text-xs leading-5 rounded-md inline-block px-1 sm:px-1 xl:px-2 py-0 sm:py-1">
                    <p><span class="hidden sm:inline">{{ $product->category->name }}</span></p>
                </span>
            </div>
        @endif
        <div class="w-full flex-none text-sm flex items-center justify-center text-gray-600 py-2">
            @if ($product->status)
                <div class="text-md font-bold">
                    <span class="text-green-500">● {{ __('In Stock') }}</span>
                </div>
            @else
                <div class="text-md font-bold">
                    <span class="text-red-500">●
                        {{ __('Out of Stock') }}</span>
                </div>
            @endif

        </div>

        <a href="{{ route('front.product', $product->slug) }}">
            <h4 class="px-2 block text-center md:text-md text-black hover:text-red-900 uppercase" itemprop="name">
                {{ Str::limit($product->name, 40) }}</h4>
        </a>

        <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            {{-- @dd($product) --}}
            <p class="text-center text-red-900 hover:text-red-800 font-bold text-md mt-2">
                @if ($product->warehouses->first()->pivot->is_ecommerce)
                    @if ($product->warehouses->first()->pivot->is_discount && $product->discount_date >= now())
                        <span
                            class="line-through text-gray-600">{{ format_currency($product->warehouses->first()->pivot->old_price) }}
                        </span>
                        <span
                            itemprop="price">{{ format_currency($product->warehouses->first()->pivot->price) }}</span>
                    @else
                        <span
                            itemprop="price">{{ format_currency($product->warehouses->first()->pivot->price) }}</span>
                    @endif
                @endif
            </p>

            <meta itemprop="priceValidUntil" content="{{ now()->addWeek()->toIso8601String() }}">
            <meta itemprop="priceCurrency" content="MAD">
            <meta itemprop="availability"
                content="{{ $product->status ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}">
        </div>

        <div class="flex justify-center">
            <a class="my-2 block bg-red-600 hover:bg-red-800 text-center text-white font-bold text-xs py-2 px-4 rounded-md uppercase cursor-pointer tracking-wider hover:shadow-lg transition ease-in duration-300"
                href="{{ route('front.product', $product->slug) }}">
                {{ __('Read more') }}
            </a>
        </div>
    </div>
</div>

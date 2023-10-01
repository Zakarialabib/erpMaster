<div>
    @section('title', $product->name)

    @section('meta')
        <meta itemprop="url" content="{{ URL::current() }}" />
        <meta property="og:title" content="{{ $product->meta_title }}">
        <meta property="og:description" content="{!! $product->meta_description !!}">
        <meta property="og:url" content="{{ URL::current() }}">
        <meta property="og:image" content="{{ asset('images/products/' . $product->image) }}">
        <meta property="og:image:secure_url" content="{{ asset('images/products/' . $product->image) }}">
        <meta property="og:image:width" content="1000">
        <meta property="og:image:height" content="1000">
        <meta property="product:brand" content="{{ $product->brand?->name }}">
        <meta property="product:availability" content="in stock">
        <meta property="product:condition" content="new">
        <meta property="product:price:amount" content="{{ $product->price }}">
        <meta property="product:price:currency" content="MAD">
    @endsection

    <div class="my-5">
        <div itemtype="https://schema.org/Product" itemscope>

            <meta itemprop="name" content="{{ $product->name }}" />
            <meta itemprop="description" content="{{ $product->description }}" />

            <div class="mx-auto px-4">
                <div class="flex flex-wrap -mx-4 mb-4">
                    <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}"
                            loading="lazy" class="w-full h-full object-cover">

                        @if ($product?->gallery)
                            <section class="flex items-center z-10 relative gap-[30px] lg:gap-[50px">
                                <div
                                    class="flex-1 w-[80%] grid md:grid-cols-2 sm:sm-grid-cols-1 items-center py-10 transition-all duration-500 relative">
                                    @foreach (json_decode($product->gallery) as $image)
                                        <div
                                            class="rounded-2xl p-0 flex items-center bg-white z-10 relative flex-col lg:gap-[50px] lg:flex-row">
                                            <a class="block self-stretch flex-1 aspect-[580/421]" href="#">
                                                <img class="h-full w-full object-cover rounded-2xl lg:rounded-tr-none lg:rounded-br-2xl"
                                                    src="{{ asset('images/activities/' . $image) }}"
                                                    alt="{{ $image }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>

                    <div class="w-full md:w-1/2 px-4">
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <div class="pb-5 border-b">
                                <span class="text-sm text-gray-500">
                                    <a href="">
                                        {{ $product->category?->name }}
                                    </a> /
                                    @isset($product->brand)
                                        <a
                                            href="{{ route('front.brandPage', $product->brand?->slug) }}">{{ $product->brand?->name }}</a>
                                        /
                                    @endisset
                                    <a href="{{ URL::Current() }}">
                                        {{ $product->name }}
                                    </a>
                                    <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                        <meta itemprop="brand" content="{{ $product->brand?->name }}" />
                                    </div>
                                </span>
                                <h2 class="my-2 max-w-xl lg:text-5xl sm:text-xl font-bold font-heading">
                                    {{ $product->name }}
                                </h2>

                                {{-- <div class="flex items-center">
                                    <div class="flex items-center" itemprop="aggregateRating"
                                        itemtype="https://schema.org/AggregateRating" itemscope>
                                        <meta itemprop="reviewCount" content="{{ $product?->reviews->count() }}">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $product->reviews->avg('rating'))
                                                <meta itemprop="ratingValue"
                                                    content="{{ $product->reviews->avg('rating') }}">
                                                <svg class="w-4 h-4 text-orange-500 fill-current"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27l-5.18 2.73 1-5.81-4.24-3.63 5.88-.49L12 6.11l2.45 5.51 5.88.49-4.24 3.63 1 5.81z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-orange-500 fill-current"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 17.27l-5.18 2.73 1-5.81-4.24-3.63 5.88-.49L12 6.11l2.45 5.51 5.88.49-4.24 3.63 1 5.81z" />
                                                </svg>
                                            @endif
                                        @endfor

                                        <span
                                            class="ml-2 text-sm text-gray-500 font-body">{{ $product->reviews->count() }}
                                            {{ __('Reviews') }}</span>
                                    </div>
                                </div> --}}
                            </div>
                            <div itemprop="offers" itemtype="https://schema.org/AggregateOffer" itemscope>
                                <p class="inline-block mb-4 text-2xl font-bold font-heading">
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


                                        <meta itemprop="lowPrice"
                                            content="{{ $product->warehouses->first()->pivot->old_price }}">
                                        <meta itemprop="highPrice"
                                            content="{{ $product->warehouses->first()->pivot->price }}">
                                        <meta itemprop="price"
                                            content="{{ $product->warehouses->first()->pivot->price }}">
                                    @endif
                                    <meta itemprop="priceCurrency" content="MAD">
                                    <link itemprop="availability" href="http://schema.org/InStock">
                                    <link itemprop="itemCondition" href="http://schema.org/NewCondition">
                                    <meta itemprop="priceValidUntil" content="2023-12-30">

                                </p>

                                @if ($product->warehouses->first()->pivot->old_price && $product->warehouses->first()->pivot->discount != 0)
                                    <p class="mb-8 text-blue-300">
                                        <span class="font-normal text-base text-gray-400 line-through">
                                            {{ format_currency($product->warehouses->first()->pivot->old_price) }}
                                        </span>
                                    </p>
                                @endif
                            </div>

                            <div class="flex mb-5 pb-5 border-b">
                                <div class="mr-6">
                                    <div
                                        class="inline-flex items-center px-4 font-semibold font-heading text-gray-500 border border-gray-200 focus:ring-blue-300 focus:border-blue-300 rounded-md">
                                        <button wire:click="decreaseQuantity('{{ $product->id }}')"
                                            class="py-2 hover:text-gray-700">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z"
                                                    clip-rule="evenodd">
                                                </path>
                                            </svg>
                                        </button>
                                        <input
                                            class="w-10 m-0 px-2 py-2 text-center border-0 focus:ring-transparent focus:outline-none rounded-md"
                                            value="{{ $quantity }}" wire:model="quantity">
                                        <button wire:click="increaseQuantity('{{ $product->id }}')"
                                            class="py-2 hover:text-gray-700">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 5a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V6a1 1 0 011-1z"
                                                    clip-rule="evenodd">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    @if ($product->status == true)
                                        <button type="button"
                                            class="block text-center text-white font-bold font-heading py-2 px-4 rounded-md uppercase bg-green-400 hover:bg-green-600 transition cursor-pointer"
                                            wire:click="AddToCart('{{ $product->id }}','{{ $product->warehouses->first()->pivot->price }}')"
                                            wire:loading.attr="disabled">
                                            {{ __('Add to cart') }}
                                        </button>
                                    @else
                                        <div class="text-sm font-bold">
                                            <span class="text-red-500">● {{ __('Out of Stock') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <livewire:front.order-form :product="$product" lazy />

                            <div class="flex items-center">
                                <span
                                    class="mr-8 text-gray-500 font-bold font-heading uppercase">{{ __('SHARE IT') }}</span>
                                <a class="mr-1 w-8 h-8" href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="mr-1 w-8 h-8" href="#">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="w-8 h-8" href="#">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a class="w-8 h-8" href="#">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ activeTab: 'description' }" class="mx-auto px-4 border flex items-center bg-white shadow-xl">
                    <div class="md:w-1/4 flex flex-col">
                        <button @click="activeTab = 'description'"
                            :class="activeTab === 'description' ? 'text-green-400' : ''"
                            class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                            {{ __('Description') }}
                        </button>

                        @if ($product->embeded_video)
                            <button @click="activeTab = 'video'" :class="activeTab === 'video' ? 'text-green-400' : ''"
                                class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                                {{ __('Video') }}
                            </button>
                        @endif

                        <button @click="activeTab = 'reviews'" :class="activeTab === 'reviews' ? 'text-green-400' : ''"
                            class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                            {{ __('Reviews') }}
                        </button>
                        <button @click="activeTab = 'how-to-use'"
                            :class="activeTab === 'how-to-use' ? 'text-green-400' : ''"
                            class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                            {{ __('How to Use') }}
                        </button>
                    </div>
                    <div class="md:w-3/4 px-2">
                        <div x-show="activeTab === 'description'" class="px-5 mb-10">
                            <div role="description">
                                <livewire:utils.editor-js editor-id="myEditor" :value="$product?->description" :read-only="true" />
                            </div>
                        </div>
                        @if ($product->embeded_video)
                            <div x-show="activeTab === 'video'" class="px-5 mb-10">
                                <div role="video">
                                    <p class="mb-8 max-w-2xl text-gray-500 font-body">
                                        {!! $product->embeded_video !!}
                                    </p>
                                </div>
                            </div>
                        @endif


                        <div x-show="activeTab === 'reviews'" class="px-5 mb-10">
                            <div role="reviews">
                                {{--  --}}
                            </div>
                        </div>

                        <div x-show="activeTab === 'how-to-use'" class="px-5 mb-10">
                            <div role="how-to-use">
                                <p class="mb-8 max-w-2xl text-gray-500 font-body">
                                    {{ $product->usage }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full px-10 mt-4 bg-green-100 border-white border-2 bg-gray-80 py-6 mx-auto shadow-md">
                    <div class="grid grid-cols-1 gap-[30px] sm:grid-cols-2 lg:grid-cols-3">
                        <div class="flex flex-col gap-y-2">
                            <div class="flex items-center justify-center bg-gray-60 rounded-md w-[51px] h-[51px]">
                                <div class="w-8 h-8 overflow-hidden"> <img class="w-full h-full object-cover"
                                        src="{{ asset('images/delivery.svg') }}" alt="Delivery">
                                </div>
                            </div><span class="text-header-6 font-bold text-first-brand">Fast Delivery</span>
                            <p class="text-mini-desc font-medium text-gray-500">We come together wherever we are –
                                across time
                                zones, regions, offices and screens. You will receive support from your teammates
                                anytime and
                                anywhere.</p>
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex items-center justify-center bg-gray-60 rounded-md w-[51px] h-[51px]">
                                <div class="w-8 h-8 overflow-hidden"> <img class="w-full h-full object-cover"
                                        src="{{ asset('images/secure.svg') }}" alt="Secure">
                                </div>
                            </div><span class="text-header-6 font-bold text-first-brand">Secure payment</span>
                            <p class="text-mini-desc font-medium text-gray-500">Our teams reflect the rich
                                diversity of
                                our
                                world, with equitable access to opportunity for everyone. No matter where you come
                                from
                            </p>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <div class="flex items-center justify-center bg-gray-60 rounded-md w-[51px] h-[51px]">
                                <div class="w-8 h-8 overflow-hidden"> <img class="w-full h-full object-cover"
                                        src="{{ asset('images/return.svg') }}" alt="Return">
                                </div>
                            </div><span class="text-header-6 font-bold text-first-brand">Return &amp; Refund</span>
                            <p class="text-mini-desc font-medium text-gray-500">Knowing that there is real value to
                                be
                                gained
                                from helping people to simplify whatever it is that they do and bring.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mx-auto px-4 mt-5">
                <h4
                    class="text-first-brand font-extrabold text-md sm:text-lg md:text-xl lg:text-header-2 mx-auto capitalize relative">
                    {{ __('Related Products') }}
                </h4>
                <div class="bg-white my-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 py-2 px-2">
                    @foreach ($relatedProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @livewire('front.cart-count')

</div>

<div>
    @section('title', __('Home'))

    <div class="relative mx-auto mb-5">
        <section class="w-full mx-auto bg-gray-900 h-auto relative">
            <x-theme.slider :sliders="$this->sliders" />
        </section>

        <div class="w-full py-5 px-4 mx-auto">
            <div class="flex flex-col">
                <h2
                    class="text-first-brand font-extrabold text-md sm:text-lg md:text-xl lg:text-header-2 mx-auto capitalize relative max-w-[778px]">
                    {{ __('Choose your favorite choice') }}
                </h2>

                <div class="flex flex-wrap justify-center overflow-x-scroll gap-4 py-4">
                    @foreach ($this->subcategories as $subcategory)
                        <a href="{{ route('front.subcategoryPage', $subcategory->slug) }}" class="relative w-44 h-44"
                            x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                            <div
                                class="absolute top-0 left-0 right-0 bottom-0 rounded-full bg-white shadow-lg transform hover:scale-105 transition-all duration-300">
                                <img class="absolute inset-0 w-full h-full object-cover rounded-full transform-gpu transition-all duration-1000 ease-in-out"
                                    :class="{ 'rotate-0': !hover, 'rotate-360': hover }"
                                    src="{{ asset('images/subcategories/' . $subcategory->image) }}"
                                    alt="{{ $subcategory->name }}">
                                <div class="absolute inset-0 flex items-center justify-center text-center">
                                    <p class="text-md text-white  w-full font-bold bg-black opacity-75 shadow ">
                                        {{ $subcategory->name }} {{ __('for') }}
                                        {{ $subcategory->category?->name }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full mx-auto px-6">
            <div x-data="{ activeTabs: 'featuredProducts' }" class="px-4 py-5 bg-white">
                <div class="grid gap-4 xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 mb-10 ">
                    @if ($this->featuredProducts)
                        <div class="py-5 px-8 sm:py-2 sm:px-5 text-left font-bold text-gray-500 uppercase border-b-2 border-beige-100 hover:border-beige-500 focus:outline-none focus:border-beige-500 cursor-pointer"
                            @click="activeTabs = 'featuredProducts'"
                            :class="{
                                'border-beige-500': activeTabs === 'featuredProducts',
                                'text-green-500': activeTabs === 'featuredProducts',
                                'hover:text-green-500': activeTabs !== 'featuredProducts'
                            }">
                            <h4 class="inline-block" :class="{ 'text-green-400': activeTabs === 'featuredProducts' }">
                                {{ __('Featured Products') }}
                            </h4>
                        </div>
                    @endif
                    @if ($this->bestOffers)
                        <div class="py-5 px-8 sm:py-2 sm:px-5 text-left font-bold text-gray-500 uppercase border-b-2 border-beige-100 hover:border-beige-500 focus:outline-none focus:border-beige-500 cursor-pointer"
                            @click="activeTabs = 'bestOfers'"
                            :class="{
                                'border-beige-500': activeTabs === 'bestOfers',
                                'text-green-500': activeTabs === 'bestOfers',
                                'hover:text-green-500': activeTabs !== 'bestOfers'
                            }">
                            <h4 class="inline-block" :class="{ 'text-green-400': activeTabs === 'bestOfers' }">
                                {{ __('Best Offers') }}
                            </h4>
                        </div>
                    @endif
                    @if ($this->hotProducts)
                        <div class="py-5 px-8 sm:py-2 sm:px-5 text-left font-bold text-gray-500 uppercase border-b-2 border-beige-100 hover:border-beige-500 focus:outline-none focus:border-beige-500 cursor-pointer"
                            @click="activeTabs = 'hotProducts'"
                            :class="{
                                'border-beige-500': activeTabs === 'hotProducts',
                                'text-green-500': activeTabs === 'hotProducts',
                                'hover:text-green-500': activeTabs !== 'hotProducts'
                            }">
                            <h4 class="inline-block" :class="{ 'text-green-400': activeTabs === 'hotProducts' }">
                                {{ __('Hot Products') }}
                            </h4>
                        </div>
                    @endif
                </div>

                @if ($this->featuredProducts)
                    <div class="px-4" x-show="activeTabs === 'featuredProducts'">
                        <div role="featuredProducts" aria-labelledby="tab-0" id="tab-panel-0" tabindex="0"
                            class="w-full mb-16">
                            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
                                @foreach ($this->featuredProducts as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if ($this->bestOffers)
                    <div class="px-4" x-show="activeTabs === 'bestOfers'">
                        <div role="bestOfers" aria-labelledby="tab-1" id="tab-panel-1" tabindex="0"
                            class="w-full mb-16">
                            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
                                @foreach ($this->bestOffers as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if ($this->hotProducts)
                    <div class="px-4" x-show="activeTabs === 'hotProducts'">
                        <div role="hotProducts" aria-labelledby="tab-2" id="tab-panel-2" tabindex="0"
                            class="w-full mb-16">
                            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
                                @foreach ($this->hotProducts as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="py-5 px-4 mx-auto bg-gray-100">
            <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 w-full py-10">
                @foreach ($this->sections as $section)
                    <div class="px-3 mb-6">
                        <div class="relative h-full text-center pt-16 bg-white">
                            <div class="pb-12 border-b">
                                <h3 class="mb-4 text-center text-xl font-bold font-heading">{{ $section->title }}</h3>
                                @if ($section->subtitle)
                                    <p>{{ $section->subtitle }}</p>
                                @endif
                            </div>
                            <div class="py-5 px-4 text-center">
                                <p class="text-lg text-gray-500">
                                    {!! $section->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

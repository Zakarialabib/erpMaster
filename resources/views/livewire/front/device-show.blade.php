<div>
    @section('meta')
        <meta itemprop="url" content="{{ URL::current() }}" />
        <meta property="og:title" content="{{ $device_model->meta_title }}">
        <meta property="og:description" content="{!! $device_model->meta_description !!}">
        <meta property="og:url" content="{{ URL::current() }}">
        <meta property="og:image" content="{{ asset('images/products/' . $device_model->image) }}">
        <meta property="og:image:secure_url" content="{{ asset('images/products/' . $device_model->image) }}">
        <meta property="og:image:width" content="1000">
        <meta property="og:image:height" content="1000">
        <meta property="product:brand" content="{{ $device_model->brand?->name }}">
    @endsection

    @section('title', __('Device Model ') . $device_model->name)

    <div class="my-5">
        <div itemtype="https://schema.org/Product" itemscope>

            <meta itemprop="name" content="{{ $device_model->name }}" />
            <meta itemprop="description" content="{{ $device_model->description }}" />

            <div class="py-10 px-6 mx-4 bg-white border shadow-xl">
                <div class="flex flex-wrap -mx-4 mb-14">
                    <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                        <img src="{{ asset('images/device-models/' . $device_model->image) }}" 
                            alt="{{ $device_model->name }}"  loading="lazy"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="w-full md:w-1/2 px-4">
                        <div class="mb-5 pb-5 border-b">
                            <span class="text-gray-500">
                                @isset($device_model->brand)
                                    <a
                                        href="{{ route('front.brandPage', $device_model->brand?->slug) }}">{{ $device_model->brand?->name }}</a>
                                @endisset
                                <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                    <meta itemprop="brand" content="{{ $device_model->brand?->name }}" />
                                </div>
                            </span>
                            <h2 class="mt-2 mb-6 max-w-xl lg:text-5xl sm:text-xl font-bold font-heading">
                                {{ $device_model->name }}
                            </h2>
                        </div>

                        <div class="fw-full my-5 border-b" x-data="{ showTech: true }">
                            <div class="relative w-full flex items-center space-between mb-4">
                                <button @click="showTech = !showTech">
                                    <h4 class="text-xl font-bold font-heading">
                                        {{ __('Technical Details') }}
                                    </h4>
                                </button>
                                <button @click="showTech = !showTech"
                                    class="float-right text-gray-500 font-medium py-2 pl-4">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div class="w-full py-4" x-show="showTech">
                                <table class="table-auto">
                                    <tbody>
                                        @foreach ($device_model->technical_details as $key => $value)
                                            <tr>
                                                <td class="text-gray-500 font-medium py-2 pr-4">{{ $key }}
                                                </td>
                                                <td class="text-gray-500 py-2">{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full mb-5 border-b" x-data="{ showSpecs: false }">
                            <div class="relative w-full flex items-center space-between mb-4">
                                <button @click="showSpecs = !showSpecs">
                                    <h4 class="text-xl font-bold font-heading">
                                        {{ __('Specifications') }}
                                    </h4>
                                </button>
                                <button @click="showSpecs = !showSpecs"
                                    class="float-right text-gray-500 font-medium py-2 pl-4">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div class="w-full py-4" x-show="showSpecs">
                                <table class="table-auto">
                                    <tbody>
                                        @foreach ($device_model->specifications as $key => $value)
                                            <tr>
                                                <td class="text-gray-500 font-medium py-2 pr-4">{{ $key }}
                                                </td>
                                                <td class="text-gray-500 py-2">
                                                    @if (is_array($value))
                                                        <ul>
                                                            @foreach ($value as $subKey => $subValue)
                                                                <li>{{ $subKey }}: {{ $subValue }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full mb-5 border-b" x-data="{ showBrand: false }">
                            <div class="relative w-full flex items-center space-between mb-4">
                                <button @click="showBrand = !showBrand">
                                    <h4 class="text-xl font-bold font-heading">
                                        {{ __('Brand information') }}
                                    </h4>
                                </button>
                                <button @click="showBrand = !showBrand"
                                    class="float-right text-gray-500 font-medium py-2 pl-4">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div class="w-full py-4" x-show="showBrand">
                                <div class="mb-5 pb-5 border-b">
                                    <span
                                        class="px-3 py-1 border border-blue-500 rounded-full text-xs text-blue-500 font-bold font-heading uppercase">
                                        {{ $brand->name }}
                                    </span>
                                    <div class="mt-6 mb-8">
                                        <img class="h-auto" src="{{ asset('images/brands/' . $brand->image) }}"
                                            alt="{{ $brand->name }}" loading="lazy">
                                    </div>
                                    <p class="mb-10 px-5 text-md text-gray-800">
                                        {{ $brand->description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mb-5">
                                <h4 class="mb-2 text-xl font-bold font-heading">
                                    {{ __('Features') }}
                                </h4>
                                <div class="mb-2">
                                    @foreach ($device_model->features as $key => $value)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">{{ $key }}</span>
                                            <span class="text-gray-500">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div> --}}



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

            <div x-data="{ activeTab: 'similarProducts' }" class="py-4 mt-5 px-6 mx-4 border bg-white shadow-xl">
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-10">
                    <div
                        class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                        <button @click="activeTab = 'similarProducts'"
                            :class="activeTab === 'similarProducts' ? 'text-move-400' : ''">
                            {{ __('Similar Products') }}
                        </button>
                    </div>

                    <div
                        class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                        <button @click="activeTab = 'relatedProducts'"
                            :class="activeTab === 'relatedProducts' ? 'text-move-400' : ''">
                            {{ __('Related Products') }}
                        </button>
                    </div>
                    <div
                        class="inline-block py-6 px-10 text-left font-bold font-heading text-gray-500 uppercase border-b-2 border-gray-100 hover:border-gray-500 focus:outline-none focus:border-gray-500">
                        <button @click="activeTab = 'brandDevices'"
                            :class="activeTab === 'brandDevices' ? 'text-move-400' : ''">
                            {{ __('Brand Devices') }}
                        </button>
                    </div>
                </div>
                <div x-show="activeTab === 'similarProducts'" class="px-5 mb-10">
                    <div role="similarProducts" aria-labelledby="tab-0" id="tab-panel-0" tabindex="0">
                        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 -mx-2 px-2">
                            @foreach ($similarProducts as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'relatedProducts'" class="px-5 mb-10">
                    <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 -mx-2 px-2">
                        @foreach ($relatedProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>

                <div x-show="activeTab === 'brandDevices'" class="px-5 mb-10">
                    <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 -mx-2 px-2">
                        @foreach ($brand_device_models as $deviceModel)
                            <x-deviceModel-card :deviceModel="$deviceModel" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <section class="py-14 dark:bg-white/[0.03] lg:py-20">
            <div class="px-6">
                <div class="w-full flex flex-col items-center justify-center mb-4">
                    <div class="heading text-center rtl:lg:text-right">
                        <h6
                            class="text-3xl font-bold sm:!leading-[50px] heading text-center rtl:lg:text-right !text-indigo-600">
                            {{ __('Blog') }}</h6>
                        <h4>{{ __('Unlock the latest trends/news') }}</h4>
                    </div>
                </div>
                <div
                    class="Swiper blog-slider swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                    <div class="swiper-wrapper">
                        @foreach (\App\Helpers::getActiveBlogs() as $blog)
                            <div class="rounded-3xl bg-white dark:bg-gray-dark">
                                <img src="assets/images/modern-saas/marketing.png" alt="blog-3"
                                    class="h-52 w-full rounded-t-3xl object-cover">
                                <div class="p-5 text-sm font-bold">
                                    <span
                                        class="rounded bg-indigo-600/10 py-1 px-2 text-sm font-extrabold text-indigo-600">Marketing</span>
                                    <a href="blog-details.html"
                                        class="my-[10px] block text-lg font-extrabold leading-[23px] text-black transition line-clamp-2 hover:text-indigo-800 dark:text-white dark:hover:text-indigo-800">
                                        What’s growth hacking? 8 great books to learn more about it
                                    </a>
                                    <p class="line-clamp-3">
                                        The use of resource-light and cost-effective digital marketing tactics to help
                                        grow and retain an active user
                                        base, sell products and...
                                    </p>
                                    <div class="mt-6 flex items-center justify-between text-indigo-800">
                                        <span>Dec 25, 2022</span>
                                        <a href="blog-details.html" class="transition hover:text-indigo-600">
                                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M25.4091 13.0009C25.4091 19.8539 19.8531 25.41 13 25.41C6.14699 25.41 0.590937 19.8539 0.590937 13.0009C0.590937 6.14785 6.14699 0.591797 13 0.591797C19.8531 0.591797 25.4091 6.14785 25.4091 13.0009ZM12.7226 7.55043C12.6336 7.63872 12.5628 7.74368 12.5144 7.85931C12.466 7.97495 12.4408 8.09899 12.4403 8.22436C12.4398 8.34973 12.464 8.47398 12.5115 8.58999C12.559 8.70601 12.6289 8.81153 12.7172 8.90052L15.8386 12.0463H7.86935C7.61618 12.0463 7.37339 12.1469 7.19438 12.3259C7.01537 12.5049 6.9148 12.7477 6.9148 13.0009C6.9148 13.254 7.01537 13.4968 7.19438 13.6759C7.37339 13.8549 7.61618 13.9554 7.86935 13.9554H15.8386L12.7172 17.1013C12.6289 17.1903 12.5591 17.2959 12.5116 17.412C12.4641 17.5281 12.4399 17.6524 12.4405 17.7778C12.441 17.9033 12.4663 18.0273 12.5148 18.143C12.5633 18.2587 12.6341 18.3636 12.7232 18.4519C12.8123 18.5402 12.9179 18.6101 13.034 18.6576C13.1501 18.7051 13.2744 18.7292 13.3998 18.7287C13.5252 18.7281 13.6493 18.7029 13.765 18.6544C13.8806 18.6059 13.9856 18.5351 14.0739 18.446L18.8102 13.6732C18.9876 13.4944 19.0872 13.2528 19.0872 13.0009C19.0872 12.749 18.9876 12.5073 18.8102 12.3285L14.0739 7.5558C13.9856 7.46661 13.8806 7.39571 13.7648 7.34716C13.6491 7.29861 13.5249 7.27336 13.3994 7.27286C13.2739 7.27236 13.1495 7.29662 13.0333 7.34425C12.9172 7.39188 12.8116 7.46194 12.7226 7.55043Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

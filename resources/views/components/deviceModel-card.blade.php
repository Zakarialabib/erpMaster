@props(['deviceModel'])
<div itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
    <div itemprop="brand" content="{{ $deviceModel->brand }}"></div>
    <div itemprop="sku" content="{{ $deviceModel->code }}"></div>
    <div itemprop="description" content="{{ $deviceModel->description }}"></div>

    <div class="mb-5 bg-white rounded-lg shadow-2xl sm:w-full">
        <div class="relative text-left">
            <a href="{{ route('front.deviceshow', $deviceModel->slug) }}" class="flex justify-center" itemprop="url">
                <img class="lg:h-[250px] md:h-[150px] object-fill py-2"
                    src="{{ asset('images/device-models/' . $deviceModel->image) }}" onerror="this.onerror=null; this.remove();"
                    alt="{{ $deviceModel->name }}" loading="lazy" />
                <meta itemprop="image" content="{{ asset('images/device-models/' . $deviceModel->image) }}" />
            </a>
        </div>
        <div class="px-2 pb-4 text-left">
            
            <a href="{{ route('front.deviceshow', $deviceModel->slug) }}">
                <h4 class="block text-center mb-2 lg:text-md md:text-sm font-bold font-heading hover:text-move-600"
                    itemprop="name">
                    {{ Str::limit($deviceModel->name, 40) }}</h4>
            </a>

            <div class="flex justify-center">
                <a class="my-2 block bg-move-500 hover:bg-move-800 text-center text-white font-bold text-xs py-2 px-4 rounded-md uppercase cursor-pointer tracking-wider hover:shadow-lg transition ease-in duration-300"
                href="{{ route('front.deviceshow', $deviceModel->slug )}}" wire:loading.attr="disabled">
                    {{ __('Read more') }}
                </a>
            </div>
        </div>
    </div>
</div>

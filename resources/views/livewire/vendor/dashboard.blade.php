<div>
    <div class="container px-4 mx-auto">
        <div class="relative px-10 py-12 xl:py-16 xl:px-20 mb-8 sm:mb-14 bg-indigo-600 overflow-hidden rounded-3xl">
            <img class="absolute right-0 sm:right-12 md:right-24 top-1/2 transform -translate-y-1/2 scale-150 md:scale-100"
                src="" alt="">
            <div class="relative z-10">
                <h2 class="mb-5 text-5xl md:text-7xl text-white font-heading font-semibold">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-white max-w-xs font-medium">{{ __('You can check you product catalog ') }}
                </p>
            </div>
        </div>
       
        @livewire('vendor.account.index')
        
        @livewire('vendor.product.index')
    </div>
</div>

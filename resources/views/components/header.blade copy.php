<div x-data="{ mobileMenuOpen: false, open: false }" x-on:click.outside="open = false" class="bg-green-400 drop-shadow-xl py-2 z-50 sticky top-0 transition-transform duration-500"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center border-gray-100 md:space-x-10">
            <div class="flex justify-start">
                <a href="/" title="" class="text-gray-100 dark:text-white">
                    <img src="{{ asset('images/' . settings('site_logo') ) }}"
                        alt="{{ settings('company_name')  }}" class="h-12">
                </a>
            </div>

            <div class="-mr-2 -my-2 md:hidden">
                <button @click="mobileMenuOpen = mobileMenuOpen ? false : true" type="button"
                    class="dark:bg-slate-900 dark:text-slate-400 p-2 inline-flex items-center justify-center text-white hover:text-blue-500"
                    aria-expanded="false">
                    <span class="sr-only">{{ __('Open menu') }}</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <x-navigation.desktop />
        </div>
    </div>

    <div style="display: none" x-show="mobileMenuOpen" x-transition:enter="duration-200 ease-out"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @click.away="mobileMenuOpen = false" type="button"
        class="absolute inset-x-0 p-2 w=full md:hidden">
        <div
            class="relative top-2 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white dark:bg-slate-900 divide-y-2 divide-gray-50">
            <x-navigation.mobile />
        </div>
    </div>
</div>

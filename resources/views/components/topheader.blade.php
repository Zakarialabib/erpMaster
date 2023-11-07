<div class="px-4 py-2 bg-red-700 text-white">
    <div class="flex items-center justify-center md:justify-between">
        <a class="text-xs text-center font-semibold font-heading hover:text-red-950 hover:underline cursor-pointer"
            href="tel:{{ settings('company_phone') }}">
            <i class="fa fa-phone mr-2"></i> {{ settings('company_phone') }}
        </a>

        @if (auth()->guard('customer')->check() ||
                auth()->guard('admin')->check())
            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <div class="flex items-center text-white gap-2 px-4">
                        <i class="fa fa-caret-down ml-2"></i>
                        {{ auth()->guard('customer')->user()->name ??auth()->guard('admin')->user()->name }}
                    </div>
                </x-slot>

                <x-slot name="content">
                    {{-- if admin show dashboard and settings else show logout --}}
                    @if (Auth::guard('admin')->check())
                        <x-dropdown-link href="{{ route('admin.dashboard') }}">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.settings.index')">
                            {{ __('Settings') }}
                        </x-dropdown-link>
                    @elseif (auth()->guard('customer'))
                        <x-dropdown-link href="{{ route('front.myaccount') }}">
                            {{ __('My account') }}
                        </x-dropdown-link>
                    @endif

                    <div class="border-t border-gray-100"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        @else
            <button class="flex-shrink-0 hidden md:block px-4">
                <div class="flex items-center text-white space-x-2">
                    <a href="{{ route('auth.login') }}"
                        class="mr-2 text-xs text-center font-semibold font-heading hover:text-red-950 hover:underline cursor-pointer">{{ __('Login') }}
                    </a>
                    <a href="{{ route('auth.register') }}"
                        class="ml-2 text-xs text-center font-semibold font-heading hover:text-red-950 hover:underline cursor-pointer">
                        {{ __('Register') }}</a>
                </div>
            </button>
        @endif
    </div>
</div>

<section class="py-5 px-6 bg-white shadow">
    <div class="flex items-center justify-between flex-shrink-0 px-4">
        <!-- Logo -->
        <a href="{{ route('vendor.dashboard') }}" class="text-xl font-semibold">
            <img class="w-4 h-auto text-white" src="{{ asset('images/' . Helpers::settings('site_logo')) }}"
                alt="{{ Helpers::settings('company_name') }}">
            <span class="sr-only">
                {{ Helpers::settings('company_name') }}
            </span>
        </a>
    </div>
    >
</section>

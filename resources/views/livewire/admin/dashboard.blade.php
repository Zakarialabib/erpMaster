<div>
    @section('title', __('Dashboard'))
    @can('dashboard access')
        <x-theme.breadcrumb :title="__('Dashboard')" :parent="route('admin.suppliers.index')" :parentName="__('Dashboard')">
            <livewire:utils.livesearch />
        </x-theme.breadcrumb>

        <div class="w-full py-6">
            {{-- <livewire:admin.customers.google-contact  /> --}}
            <livewire:admin.stats.transactions />
        </div>
    @endcan
</div>

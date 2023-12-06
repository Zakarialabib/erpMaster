<div>
    @section('title', __('Dashboard'))
    @can('dashboard access')
        <x-theme.breadcrumb :title="__('Dashboard')" :parent="route('admin.suppliers.index')" :parentName="__('Dashboard')">
            <livewire:utils.livesearch />
        </x-theme.breadcrumb>

        <div class="w-full py-6">
            <x-button type="button" primary wire:click="$dispatch('docModal')">
                open Modal
            </x-button>
            {{-- <livewire:admin.customers.google-contact  /> --}}
            <livewire:admin.stats.transactions />
        </div>
    @endcan
    <livewire:utils.doc-reader />
</div>

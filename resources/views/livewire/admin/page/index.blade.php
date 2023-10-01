<div>
    @section('title', __('Pages'))

    <x-theme.breadcrumb :title="__('Page List')" :parent="route('admin.pages.index')" :parentName="__('Page List')">
        <x-button primary href="/admin/page/create">
            {{ __('Create Page') }}
        </x-button>
    </x-theme.breadcrumb>

    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap gap-6 w-full">
            <select wire:model.live="perPage"
                class="w-auto shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="deleteSelectedModal" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
            @endif
            @if ($this->selectedCount)
                <p class="text-sm  my-auto">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full ">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th sortable :direction="$sorts['title'] ?? null" field="title" wire:click="sortingBy('title')">
                {{ __('Title') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('slug')" field="slug" :direction="$sorts['slug'] ?? null">
                {{ __('Slug') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($pages as $page)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $page->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $page->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $page->title }}
                    </x-table.td>
                    <x-table.td>
                        <a href="{{ route('front.dynamicPage', $page->slug) }}" target="_blank">
                            {{ $page->slug }}
                        </a>
                    </x-table.td>
                    <x-table.td>
                        <livewire:utils.toggle-button :model="$page" field="status" key="{{ $page->id }}"
                            lazy />
                    </x-table.td>
                    <x-table.td>
                        <x-button alert href="/admin/page/{{ $page->id }}/edit">
                            <i class="fas fa-edit"></i>
                        </x-button>
                        <x-button danger type="button" wire:click="$dispatch('deleteModal', {{ $page->id }})"><i
                                class="fas fa-trash-alt"></i>
                        </x-button>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10" class="text-center">
                        {{ __('No entries found.') }}
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div>
        <div class="pt-3">

            {{ $pages->links() }}
        </div>
    </div>

    <livewire:admin.page.template lazy />

</div>

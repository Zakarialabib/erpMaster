<div>
    @section('title', __('Blog Categories'))
    <x-theme.breadcrumb :title="__('Blog Categories List')" :parent="route('admin.blog-categories.index')" :parentName="__('Blog Categories List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.blog-category.create', 'createModal')">
            {{ __('Create Blog Category') }}
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
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
                <p wire:click="resetSelected" wire:loading.attr="disabled"
                    class="text-sm leading-5 font-medium text-red-500 cursor-pointer ">
                    {{ __('Clear Selected') }}
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
            <x-table.th sortable :direction="$sorts['name'] ?? null" field="name" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($blogcategories as $blogcategory)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $blogcategory->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $blogcategory->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $blogcategory->title }}
                    </x-table.td>
                    <x-table.td>
                        <livewire:utils.toggle-button :model="$blogcategory" field="featured" lazy
                            key="{{ $blogcategory->id }}" />
                    </x-table.td>
                    <x-table.td>
                        <x-button primary type="button"
                            wire:click="$dispatch('editModal', { id: {{ $blogcategory->id }} })"
                            wire:loading.attr="disabled">
                            <i class="fas fa-edit"></i>
                        </x-button>
                        <x-button danger type="button" wire:click="deleteModal({{ $blogcategory->id }})"
                            wire:loading.attr="disabled">
                            <i class="fas fa-trash-alt"></i>
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

    <div class="pt-3">
        {{ $blogcategories->links() }}
    </div>

    <!-- Create Modal -->
    <livewire:admin.blog-category.create lazy />
    <!-- Edit Modal -->
    <livewire:admin.blog-category.edit blogcategory="{{ $blogcategory }}" lazy />
</div>

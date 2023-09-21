<div>
    @section('title', __('Categories'))
    <x-theme.breadcrumb :title="__('Categories List')" :parent="route('admin.product-categories.index')" :parentName="__('Categories List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.categories.import', 'importModal')">
            {{ __('Import Category') }}
        </x-button>
        <x-button primary type="button" wire:click="dispatchTo('admin.categories.create', 'createModal')">
            {{ __('Create Category') }}
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
                <x-button danger type="button" wire:click="deleteSelected" class="ml-3">
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
            <x-table.th>
                <input wire:model.live="selectPage" type="checkbox" />
            </x-table.th>
            <x-table.th sortable :direction="$sorts['name'] ?? null" field="name" wire:click="sortingBy('name')">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th>
                {{ __('Products count') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
            </tr>
        </x-slot>
        <x-table.tbody>
            @forelse($categories as $category)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $category->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $category->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        <button type="button" wire:click="showModal({{ $category->id }})">
                            {{ $category->name }}
                        </button>
                    </x-table.td>
                    <x-table.td>
                        <x-badge type="info">
                            {{ $category->products->count() }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td>
                        <x-badge type="info">
                            {{ $category->status ? __('Active') : __('Inactive') }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td>
                        <x-dropdown
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <x-slot name="trigger">
                                <button type="button"
                                    class="px-4 text-base font-semibold text-gray-500 hover:text-sky-800 dark:text-slate-400 dark:hover:text-sky-400">
                                    <i class="fas fa-angle-double-down"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link wire:click="showModal({{ $category->id }})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-eye"></i>
                                    {{ __('Show') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="$dispatch('editModal',{ id :  {{ $category->id }}})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i>
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="$dispatch('deleteModal',{ id :  {{ $category->id }}})"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
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

    <div class="p-4">
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $categories->links() }}
        </div>
    </div>

    <livewire:admin.categories.edit :category="$category" />

    <!-- Show Modal -->
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show Category') }} {{ $category?->name }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-wrap -mx-2 mb-3">
                <div class="w-full mb-4">
                    <label for="code">{{ __('Category Code') }}</label>
                    {{ $category?->code }}
                </div>
                <div class="w-full mb-4">
                    <label for="name">{{ __('Category Name') }}</label>
                    {{ $category?->name }}
                </div>
            </div>
        </x-slot>
    </x-modal>
    <!-- End Show Modal -->


    <livewire:admin.categories.import lazy />

    <livewire:admin.categories.create lazy />



</div>

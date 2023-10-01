<div>
    @section('title', __('Blogs'))

    <x-theme.breadcrumb :title="__('Blog List')" :parent="route('admin.blogs.index')" :parentName="__('Blog List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.blog.create', 'createModal')">
            {{ __('Create Blog') }}
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
            <x-table.th>
                {{ __('Image') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['title'] ?? null" field="title" wire:click="sortingBy('title')">
                {{ __('Title') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($blogs as $blog)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $blog->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $blog->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        @php
                            $photo = $blog->photo ? url('assets/images/blogs/' . $blog->photo) : url('assets/images/noimage.png');
                        @endphp
                        <img src="{{ $photo }}" alt="Image">
                    </x-table.td>
                    <x-table.td>
                        {{ $blog->title }} -- {{ $blog->category?->title }}
                    </x-table.td>
                    <x-table.td>
                        <livewire:utils.toggle-button :model="$blog" field="status" key="{{ $blog->id }}"
                            lazy />
                    </x-table.td>
                    <x-table.td>
                        <x-button primary type="button" wire:loading.attr="disabled"
                            wire:click="$dispatch('editModal', { id: {{ $blog->id }} })">
                            <i class="fas fa-edit"></i>
                        </x-button>
                        <x-button danger type="button" wire:click="deleteModal({{ $blog->id }})"
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
        {{ $blogs->links() }}
    </div>

    <!-- Create Modal -->
    <livewire:admin.blog.create lazy />

    <!-- Edit Modal -->
    <livewire:admin.blog.edit blog="{{ $blog }}" lazy />
</div>

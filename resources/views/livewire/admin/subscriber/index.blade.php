<div>
    @section('title', __('Subscriber'))
    <x-theme.breadcrumb :title="__('Subscribers List')" :parent="route('admin.subscribers.index')" :parentName="__('Subscribers List')" />
  
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
            <x-table.th sortable wire:click="sortingBy('name')" field="name" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}

            </x-table.th>
            <x-table.th>
                {{ __('Attribute') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('status')" field="status" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($subscribers as $id=>$subscriber)
                <x-table.tr>
                    <x-table.td>
                        {{ $id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $subscriber->name }}
                    </x-table.td>
                    <x-table.td>
                        <div class="action-list">
                            <a href="javascript;;"
                                data-href="'{{ route('admin-attr-createForCategory', $subscriber->id) }}"
                                class="attribute text-white" data-toggle="modal" data-target="#attribute"> <i
                                    class="fas fa-edit"></i>{{ __('Create') }}</a>
                            @if ($subscriber->attributes()->count() > 0)
                                <a href="{{ route('admin-attr-manage', $subscriber->id) . '?type=subscriber' }}"
                                    class="edit">
                                    <i class="fas fa-edit"></i>
                                    {{ __('Manage') }}
                                </a>
                            @endif
                        </div>
                    </x-table.td>

                    <x-table.td>
                        <livewire:utils.toggle-button :model="$subscriber" field="status" key="{{ $subscriber->id }}"
                            lazy />
                    </x-table.td>
                    <x-table.td>
                        <x-dropdown
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-1">
                            <x-slot name="trigger">
                                <button type="button"
                                    class="px-4 text-base font-semibold text-gray-500 hover:text-sky-800">
                                    <i class="fas fa-angle-double-down"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link data-href="{{ route('admin-cat-edit', $subscriber->id) }}"
                                    class="edit" data-toggle="modal" data-target="#modal1"> <i
                                        class="fas fa-edit"></i>
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="javascript:;"
                                    data-href="{{ route('admin-cat-delete', $subscriber->id) }}" data-toggle="modal"
                                    data-target="#confirm-delete" class="delete"><i
                                        class="fas fa-trash-alt"></i>{{ __('Delete') }}
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

    <div>
        <div class="pt-3">
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
            {{ $subscribers->links() }}
        </div>
    </div>
</div>

<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model.live="perPage"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($this->selectedCount)
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="button"
                    wire:click="confirm('deleteSelected')" wire:loading.attr="disabled"
                    {{ $this->selectedCount ? '' : 'disabled' }}>
                    <i class="fas fa-trash"></i>
                </button>
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th sortable wire:click="sortingBy('title')" field="title" :direction="$sorts['title'] ?? null">
                {{ __('Title') }}
            </x-table.th>
            <x-table.th>
                {{ __('Permissions count') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($roles as $role)
                <x-table.tr>
                    <x-table.td>
                        <input type="checkbox" value="{{ $role->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $role->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $role->permissions->count() }}
                    </x-table.td>

                    <x-table.td>
                        <div class="inline-flex space-x-2">
                            <x-button primary wire:click="$dispatch('editModal', {{ $role->id }} )" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="delete({{ $role->id }})"
                                type="button" wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </x-button>
                        </div>
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
            {{ $roles->links() }}
        </div>
    </div>

    @livewire('admin.role.create')

    @livewire('admin.role.edit', ['role' => $role])

</div>


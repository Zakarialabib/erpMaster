<div>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap my-2">
            <select wire:model.live="perPage"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if($this->selectedCount)
            <x-button danger wire:click="deleteSelected" class="ml-3">
                <i class="fas fa-trash"></i>
            </x-button>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2">
            <div class="my-2">
                <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
            </div>
        </div>
    </div>
   
    <x-table>
        <x-slot name="thead">
            <x-table.th >
                <x-input type="checkbox" class="rounded-tl rounded-bl" wire:model.live="selectPage" />
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('name')" field="name" :direction="$sorts['name'] ?? null">
                {{ __('Name') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('connection_type')" field="connection_type" :direction="$sorts['connection_type'] ?? null">
                {{ __('Connection type') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('capability_profile')" field="capability_profile" :direction="$sorts['capability_profile'] ?? null">
                {{ __('Capability profile') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('char_per_line')" field="char_per_line" :direction="$sorts['char_per_line'] ?? null">
                {{ __('Char per line') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($printers as $printer)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $printer->id }}">
                    <x-table.td class="pr-0">
                        <x-input type="checkbox" class="rounded-tl rounded-bl" value="{{ $printer->id }}"
                            wire:model.live="selected" />
                    </x-table.td>
                    <x-table.td>
                        {{ $printer->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $printer->connection_type }}
                    </x-table.td>
                    <x-table.td>
                        {{ $printer->capability_profile }}
                    </x-table.td>
                    <x-table.td>
                        {{ $printer->char_per_line }}
                    </x-table.td>
                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            <x-button alert wire:click="showModal({{ $printer->id }})" wire:loading.attr="disabled">
                                <i class="fas fa-eye"></i>
                            </x-button>

                            <x-button primary wire:click="editModal({{ $printer->id }})" wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>

                            <x-button danger wire:click="confirm('delete', {{ $printer->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i>
                            </x-button>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="8">
                        <div class="flex items-center justify-center">
                            <span class="dark:text-gray-300">{{ __('No results found') }}</span>
                        </div>
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
            {{ $printers->links() }}
        </div>
    </div>

    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show printer') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col">
                <div class="flex flex-col">
                    <x-label for="printer.name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" required type="text" disabled
                        wire:model="printer.name" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.connection_type" :value="__('Connection type')" />
                    <x-input id="connection_type" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.connection_type" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.capability_profile" :value="__('Capability profile')" />
                    <x-input id="capability_profile" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.capability_profile" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.char_per_line" :value="__('Char per line')" />
                    <x-input id="char_per_line" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.char_per_line" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.ip_address" :value="__('Ip address')" />
                    <x-input id="ip_address" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.ip_address" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.port" :value="__('Port')" />
                    <x-input id="port" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.port" />
                </div>
                <div class="flex flex-col">
                    <x-label for="printer.path" :value="__('Path')" />
                    <x-input id="path" class="block mt-1 w-full" type="text" disabled
                        wire:model="printer.path" />
                </div>
            </div>
        </x-slot>
    </x-modal>

    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit printer') }}
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="update">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" required type="text"
                            wire:model="printer.name" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.connection_type" :value="__('Connection type')" />
                        <x-input id="connection_type" class="block mt-1 w-full" type="text"
                            wire:model="printer.connection_type" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.capability_profile" :value="__('Capability profile')" />
                        <x-input id="capability_profile" class="block mt-1 w-full" type="text"
                            wire:model="printer.capability_profile" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.char_per_line" :value="__('char per line')" />
                        <x-input id="char_per_line" class="block mt-1 w-full" type="text"
                            wire:model="printer.char_per_line" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.ip_address" :value="__('Ip address')" />
                        <x-input id="ip_address" class="block mt-1 w-full" type="text"
                            wire:model="printer.ip_address" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.port" :value="__('Port')" />
                        <x-input id="port" class="block mt-1 w-full" type="text" wire:model="printer.port" />
                    </div>
                    <div class="md:w-1/2 sm:w-full px-3">
                        <x-label for="printer.path" :value="__('Path')" />
                        <x-input id="path" class="block mt-1 w-full" type="text" wire:model="printer.path" />
                    </div>
                </div>

                <div class="w-full px-3">
                    <x-button primary type="submit" class="w-full text-center" 
                              wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>

    <livewire:admin.printer.create />
</div>


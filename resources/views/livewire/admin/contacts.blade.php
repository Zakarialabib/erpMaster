<div>
    @section('title', __('Contact forms'))

    <x-theme.breadcrumb :title="__('Contact forms')" :parent="route('admin.orderforms')" :parentName="__('Contact forms')" />

    <div class="p-4">
        <div class="flex flex-wrap justify-center">
            <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap">
                <select wire:model.live="perPage"
                    class="w-20 block p-3 leading-5 bg-white dark:bg-dark-eval-2 text-zinc-700 dark:text-zinc-300 rounded border border-zinc-300 mb-1 text-sm focus:shadow-outline-blue focus:border-blue-300 mr-3">
                    @foreach ($paginationOptions as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
                @if ($this->selected)
                    <x-button danger type="button" wire:click="deleteSelected" class="mx-3">
                        <i class="fas fa-trash-alt"></i>
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

            <div class="lg:w-1/2 md:w-1/2 sm:w-full">
                <input type="text" wire:model.live="search"
                    class="p-3 leading-5 bg-white text-gray-500 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>

        <div x-data="{ openMenuIndex: null }">

            <x-table>
                <x-slot name="thead">
                    <x-table.th>#</x-table.th>
                    <x-table.th sortable wire:click="sortBy('created_at')" field="create_at" :direction="$sorts['created_at'] ?? null">
                        {{ __('Created at') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('name')" field="name" :direction="$sorts['name'] ?? null">
                        {{ __('Name') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('email')" field="email" :direction="$sorts['email'] ?? null">
                        {{ __('Email') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('phone')" field="phone" :direction="$sorts['phone'] ?? null">
                        {{ __('Phone') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Subject') }}
                    </x-table.th>
                    <x-table.th sortable wire:click="sortBy('type')" field="type" :direction="$sorts['type'] ?? null">
                        {{ __('Type') }}
                    </x-table.th>
                    <x-table.th>
                        {{ __('Actions') }}
                    </x-table.th>
                </x-slot>
                <x-table.tbody>
                    @forelse($contacts as $index => $contact)
                        <tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $index }}">
                            <x-table.td class="flex flex-wrap gap-4">
                                <button
                                    @click="openMenuIndex = (openMenuIndex === {{ $index }}) ? null : {{ $index }}">
                                    <i class="fa fa-caret-down"
                                        :class="{
                                            'fa-caret-up': openMenuIndex === {{ $index }},
                                            'fa-caret-down': openMenuIndex !== {{ $index }}
                                        }"
                                        aria-hidden="true">
                                    </i>
                                </button>
                                <input type="checkbox" value="{{ $contact->id }}" wire:model.live="selected">
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->created_at }}
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->name }}
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->email }}
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->phone_number }}
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->subject }}
                            </x-table.td>
                            <x-table.td>
                                {{ $contact->type }}
                            </x-table.td>
                            <x-table.td>
                                <button
                                    class="font-bold border-transparent uppercase justify-center text-xs py-1 px-2 rounded shadow hover:shadow-md outline-none focus:outline-none focus:ring-2 focus:ring-offset-2 mr-1 ease-linear transition-all duration-150 cursor-pointer text-white bg-red-500 border-red-800 hover:bg-red-600 active:bg-red-700 focus:ring-red-300"
                                    wire:click="confirm('delete', {{ $contact->id }})" type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </x-table.td>
                        </tr>
                        <tr x-show="openMenuIndex === {{ $index }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95" x-cloak>
                            <td class="py-4" colspan="12">
                                <div class="text-center p-5">
                                    <p>{!! $contact->message !!}</p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="10" class="text-center">
                                {{ __('No entries found.') }}
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-table>

        </div>
        <div class="pt-3">
            {{ $contacts->links() }}
        </div>
    </div>
</div>

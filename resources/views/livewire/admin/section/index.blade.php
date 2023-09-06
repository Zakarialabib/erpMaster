<div>
    @section('title', __('Sections'))

    <x-theme.breadcrumb :title="__('Sections List')" :parent="route('admin.sections.index')" :parentName="__('Sections List')">

        <!-- Button trigger livewire modal -->
        <x-button primary type="button" wire:click="$dispatch('admin.section.template','createTemplate')">
            {{ __('Create from template') }}
        </x-button>
        <!-- Button trigger livewire modal -->
        <x-button primary type="button" wire:click="dispatchTo('admin.section.create', 'createModal')">
            {{ __('Create Section') }}
        </x-button>

    </x-theme.breadcrumb>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-col my-md-0 my-2">
            <div class="my-2 my-md-0">
                <select wire:model.live="perPage" name="perPage"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                    @foreach ($paginationOptions as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>

                @if ($this->selectedCount)
                    <p class="text-sm leading-5">
                        <span class="font-medium">
                            {{ $this->selectedCount }}
                        </span>
                        {{ __('Entries selected') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full my-2 my-md-0">
            <div class="my-2 my-md-0">
                <input type="text" wire:model.debounce.300ms="search"
                    class="p-3 leading-5 bg-white text-gray-500 rounded border border-gray-300 mb-1 text-sm w-full focus:shadow-outline-blue focus:border-blue-500"
                    placeholder="{{ __('Search') }}" />
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th>
                {{ __('Page') }}
            </x-table.th>
            <x-table.th>
                {{ __('Title') }}
            </x-table.th>
            <x-table.th>
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($sections as $section)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $section->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $section->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $section->page }}
                    </x-table.td>
                    <x-table.td>
                        {{ $section->title }}
                    </x-table.td>

                    <x-table.td>
                        <livewire:utils.toggle-button :model="$section" field="status" key="{{ $section->id }}"  lazy/>
                    </x-table.td>
                    <x-table.td>
                        <div class="inline-flex space-x-2">
                            <x-button info type="button"
                                wire:click="$dispatch('editModal', { id : {{ $section->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="deleteModal({{ $section->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash-alt"></i>
                            </x-button>
                            <x-button warning type="button" wire:click="clone({{ $section->id }})"
                                wire:loading.attr="disabled">
                                {{ __('Clone') }}
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

    <div class="card-body">
        <div class="pt-3">
            {{ $sections->links() }}
        </div>
    </div>

    <livewire:admin.section.edit :section="$section" />

    <livewire:admin.section.create lazy />

    <livewire:admin.section.template lazy />

</div>

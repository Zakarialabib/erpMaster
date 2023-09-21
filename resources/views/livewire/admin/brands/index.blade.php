<div>
    @section('title', __('Brands'))
    <x-theme.breadcrumb :title="__('Brands List')" :parent="route('admin.brands.index')" :parentName="__('Brands List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.brands.create', 'createModal')">
            {{ __('Create Brand') }}
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
                {{ __('Description') }}
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
            @forelse($brands as $brand)
                <x-table.tr>
                    <x-table.td>
                        <input type="checkbox" value="{{ $brand->id }}" wire:model.live="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $brand->name }}
                    </x-table.td>
                    <x-table.td class="whitespace-nowrap break-words">
                        {{ Str::limit($brand->description, 50, '...') }}
                    </x-table.td>

                    <x-table.td>
                        <div class="flex justify-start space-x-2">
                            @can('brand_update')
                                <x-button primary wire:click="$dispatch('editModal',{ id : {{ $brand->id }}} )" type="button"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i>
                                </x-button>
                            @endcan
                            @can('brand_delete')
                                <x-button danger wire:click="$dispatch('deleteModal',{ id : {{ $brand->id }}} )" type="button"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-trash"></i>
                                </x-button>
                            @endcan
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
            {{ $brands->links() }}
        </div>
    </div>

    <!-- Edit Modal -->
    <livewire:admin.brands.edit  :brand="$brand" lazy />
    <!-- End Edit modal -->

    <!-- Create modal -->
    <livewire:admin.brands.create lazy />
    <!-- End Create modal -->

    <!-- Import modal -->
    <x-modal wire:model="importModal">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                {{ __('Import Excel') }}
                <x-button primary wire:click="downloadSample" type="button">
                    {{ __('Download Sample') }}
                </x-button>
            </div>
        </x-slot>

        <x-slot name="content">
            <form wire:submit="import">
                <div class="mb-4">
                    <div class="my-4">
                        <x-label for="import" :value="__('Import')" />
                        <x-input id="import" class="block mt-1 w-full" type="file" name="import"
                            wire:model="import" />
                        <x-input-error :messages="$errors->get('import')" for="import" class="mt-2" />
                    </div>

                    <div class="w-full flex justify-start">
                        <x-button primary wire:click="import" type="button" wire:loading.attr="disabled">
                            {{ __('Import') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Import modal -->
</div>

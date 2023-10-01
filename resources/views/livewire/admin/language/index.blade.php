<div>
    @section('title', __('Languages'))

    <x-theme.breadcrumb :title="__('Languages List')" :parent="route('admin.languages.index')" :parentName="__('Languages List')">
        <x-button primary type="button" wire:click="dispatchTo('admin.language.create', 'createModal')">
            {{ __('Create language') }}
        </x-button>
    </x-theme.breadcrumb>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th sortable :direction="$sorts['name'] ?? null" field="name" wire:click="sortingBy('name')">
                {{ __('Language name') }}
            </x-table.th>
            <x-table.th sortable :direction="$sorts['status'] ?? null" field="status" wire:click="sortingBy('status')">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>{{ __('Default') }}</x-table.th>
            <x-table.th>{{ __('Actions') }}</x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse ($this->languages as $language)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $language->id }}">
                    <x-table.td>#</x-table.td>
                    <x-table.td>{{ $language->name }}</x-table.td>
                    <x-table.td>
                        @if ($language->status == true)
                            <x-badge primary>
                                {{ __('Active') }}
                            </x-badge>
                        @elseif($language->status == false)
                            <x-badge secondary>
                                {{ __('Inactive') }}
                            </x-badge>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        @if ($language->is_default == true)
                            <x-badge primary>
                                {{ __('Yes') }}
                            </x-badge>
                        @endif
                    </x-table.td>
                    <x-table.td>
                        @if ($language->is_default == false)
                            <x-button type="button" secondary wire:click="onSetDefault( {{ $language->id }} )">
                                {{ __('Set as Default') }}
                            </x-button>
                        @endif

                        <x-button type="button" primary wire:click="sync({{ $language->id }})">
                            {{ __('Sync') }}
                        </x-button>

                        <x-button success href="{{ route('admin.translation', $language->id) }}">
                            {{ __('Translate') }}
                        </x-button>

                        <x-button success type="button"
                            wire:click="$dispatch('editModal', { id : '{{ $language->id }}'}) ">
                            <i class="fas fa-edit"></i>
                        </x-button>

                        <x-button danger type="button" wire:click="$dispatch('deleteModal', {{ $language->id }})">
                            <i class="fas fa-trash"></i>
                        </x-button>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td class="">{{ __('No record found') }}</x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <!-- Create Language-->
    <livewire:admin.language.create lazy />

    <!-- Update Language-->
    <livewire:admin.language.edit :language="$language" lazy />

</div>

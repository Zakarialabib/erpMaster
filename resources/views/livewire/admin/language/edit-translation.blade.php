<div>
    @section('title', __('Edit') . ' ' . $language->name)
    <x-theme.breadcrumb :title="__('Edit ').$language->name" :parent="route('admin.languages.index')" :parentName="__('Languages')" children :childrenName="__('Edit Translation')">
        <x-button primary type="button" wire:click="updateTranslation">
            {{ __('update translations') }}
        </x-button>
    </x-theme.breadcrumb>
    <div class="my-2 px-4 flex justify-between items-center">
        <h2 class="text-left">
        </h2>

    </div>
    <x-table>
        <x-slot name="thead">
            <x-table.th>{{ __('System') }}</x-table.th>
            <x-table.th>{{ __('Translation') }}</x-table.th>
            <x-table.th>{{ __('Action') }}</x-table.th>
        </x-slot>
        <x-table.tbody>
            @foreach ($translations as $key => $translation)
                <x-table.tr>
                    <x-table.td class="max-w-xs h-auto overflow-hidden">
                        <p class="truncate">{{ $key }}</p>
                    </x-table.td>
                    <x-table.td>
                        <x-input type="text" wire:model="translations.{{ $key }}.value" />
                    </x-table.td>
                    <x-table.td>
                        {{-- <x-button type="button" danger
                        wire:click="deleteTranslation({{ $key }})">
                        <i class="fas fa-trash"></i>
                    </x-button> --}}
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
</div>

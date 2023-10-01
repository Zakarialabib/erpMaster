<div>
    <x-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Show User') }} - {{ $user->name }}
        </x-slot>

        <x-slot name="content">
            <table class="table-fixed w-full">
                <tbody>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Name') }}</td>
                        <td class="w-3/4 px-4 py-2">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Phone') }}</td>
                        <td class="w-3/4 px-4 py-2">{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Email') }}</td>
                        <td class="w-3/4 px-4 py-2">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Status') }}</td>
                        <td class="w-3/4 px-4 py-2">{{ $user->status->label() }}</td>
                    </tr>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Roles') }}</td>
                        <td class="w-3/4 px-4 py-2">
                            @foreach ($user->roles as $role)
                                <x-badge type="primary">
                                    {{ $role->name }}
                                </x-badge>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/4 px-4 py-2 font-bold">{{ __('Warehouses') }}</td>
                        <td class="w-3/4 px-4 py-2">
                            @foreach ($user->warehouses as $warehouse)
                                <x-badge type="primary">
                                    {{ $warehouse->name }}
                                </x-badge>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </x-slot>
    </x-modal>
</div>

<div>
    <form wire:submit.prevent="saveSettings">
        <div class="mb-4">
            <label for="site_maintenance_message"
                class="block font-medium mb-1">{{ __('Site Maintenance Message') }}</label>
            <x-input type="text" wire:model="site_maintenance_message" id="site_maintenance_message" />
            @error('site_maintenance_message')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="refresh"
                class="block font-medium mb-1">{{ __('Site Refresh') }}</label>
            <x-input type="text" wire:model="refresh" id="refresh" />
            @error('refresh')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="secret"
                class="block font-medium mb-1">{{ __('Site Maintenance Secret') }}</label>
            <x-input type="text" wire:model="secret" id="secret" />
            @error('secret')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="text-center">
            <x-button type="submit" primary>{{ __('Save Settings') }}</x-button>
        </div>
    </form>

    <hr class="my-4">

    <div>
        <h2 class="text-lg font-medium">{{ __('Maintenance Mode') }}</h2>
        <p class="text-sm">{{ __('Current Status') }}: {{ $status ? 'Maintenance mode' : 'Live' }}</p>
        @if($status)
            <p class="text-sm">{{__('Bypass Link')}}: <a href="{{ url($secret) }}" target="_blank">{{ url($secret) }}</a></p>
        @endif
        <div class="mt-2">
            <button wire:click="turnOn" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Turn the app On') }}</button>
            <button wire:click="turnOff" class="bg-red-500 text-white px-4 py-2 rounded">{{ __('Turn the app Off') }}</button>
        </div>
    </div>
</div>

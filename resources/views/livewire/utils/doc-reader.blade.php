<div>
    <x-modal wire:model="docModal">
        <x-slot name="title">
            {{ __('Generate Stuff') }}
        </x-slot>

        <x-slot name="content">
            <x-validation-errors class="mb-4" :errors="$errors" />
            <form wire:submit="generate">
                <div class="w-full py-2 px-3">
                    <x-fileupload wire:model="doc" :file="$doc" accept="pdf/*" />
                </div>
                <div class="text-center py-4">
                    <x-button primary type="submit" class="w-full" wire:loading.attr="disabled">
                        {{ __('Check') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>

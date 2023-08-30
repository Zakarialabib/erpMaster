<div>
    <!-- Edit Modal -->
    <x-modal wire:model.live="editModal">
        <x-slot name="title">
            {{ __('Edit Expense Category') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <div class="w-full px-3 mb-4">
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="name" type="text" class="block mt-1 w-full" wire:model.live="expenseCategory.name" />
                    <x-input-error :messages="$errors->first('expenseCategory.name')" />
                </div>
                <div class="w-full px-3 mb-4">
                    <x-label for="description" :value="__('Description')" />
                    <textarea id="description" class="block mt-1 w-full" type="text" name="description"
                        wire:model.blur="expenseCategory.description"></textarea>
                    <x-input-error :messages="$errors->get('expenseCategory.description')" for="description" class="mt-2" />
                </div>
                <div class="w-full px-3 py-2">
                    <x-button primary type="submit" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-slot>
    </x-modal>
    <!-- End Edit Modal -->
</div>
